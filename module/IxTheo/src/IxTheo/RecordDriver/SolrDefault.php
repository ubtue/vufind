<?php

namespace IxTheo\RecordDriver;

class SolrDefault extends \TueFind\RecordDriver\SolrMarc
{
    use \VuFind\I18n\Translator\TranslatorAwareTrait;

    /**
     * Get a highlighted corporation string, if available.
     *
     * @return string
     */
    public function getHighlightedCorporation()
    {
        // Don't check for highlighted values if highlighting is disabled:
        if (!$this->highlight) {
            return '';
        }
        return (isset($this->highlightDetails['corporation'][0]))
            ? $this->highlightDetails['corporation'][0] : '';
    }

    /**
     * Get secondary author and its role in a '$'-separated string
     *
     * @return array
     */
    public function getSecondaryAuthorsAndRole()
    {
        return isset($this->fields['author2_and_role']) ?
            $this->fields['author2_and_role'] : [];
    }

    /**
     * Get an array of all secondary authors (complementing getPrimaryAuthors()).
     *
     * @return array
     */
    public function getSecondaryAuthors()
    {
        if (!isset($this->fields['author2_and_role']))
            return [];

        $authors = [];
        foreach ($this->fields['author2_and_role'] as $author_and_roles) {
            $parts = explode('$', $author_and_roles);
            $authors[] = $parts[0];
        }

        return $authors;
    }

    /**
     * Get an array of all secondary authors roles (complementing
     * getPrimaryAuthorsRoles()).
     *
     * @return array
     */
    public function getSecondaryAuthorsRoles()
    {
        if (!isset($this->fields['author2_and_role']))
            return [];

        $authorsRoles = [];
        foreach ($this->fields['author2_and_role'] as $author_and_roles) {
            $parts = explode('$', $author_and_roles);
            $roles = array_slice($parts, 1);
            $roles = array_filter($roles, function($value) { return $value !== ''; });
            $authorsRoles[] = $roles;
        }

        return $authorsRoles;
    }

    /**
     * Helper function to restructure author arrays including relators
     *
     * @param array $authors Array of authors
     * @param array $roles   Array with relators of authors
     *
     * @return array
     */
    protected function getAuthorRolesArray($authors = [], $roles = [])
    {
        $authorRolesArray = [];

        if (!empty($authors)) {
            foreach ($authors as $index => $author) {
                if (!isset($authorRolesArray[$author])) {
                    $authorRolesArray[$author] = [];
                }
                if (isset($roles[$index]) && !empty($roles[$index])) {
                    if (is_array($roles[$index]))
                        $authorRolesArray[$author] = $roles[$index];
                    else
                        $authorRolesArray[$author][] = $roles[$index];
                }
            }
        }

        return $authorRolesArray;
    }

    /**
     * Get Author Information with Associated Data Fields
     *
     * @param string $index      The author index [primary, corporate, or secondary]
     * used to construct a method name for retrieving author data (e.g.
     * getPrimaryAuthors).
     * @param array  $dataFields An array of fields to used to construct method
     * names for retrieving author-related data (e.g., if you pass 'role' the
     * data method will be similar to getPrimaryAuthorsRoles). This value will also
     * be used as a key associated with each author in the resulting data array.
     *
     * @return array
     */
    public function getAuthorDataFields($index, $dataFields = [])
    {
        $data = $dataFieldValues = [];

        // Collect author data
        $authorMethod = sprintf('get%sAuthors', ucfirst($index));
        $authors = $this->tryMethod($authorMethod, [], []);

        // Collect attribute data
        foreach ($dataFields as $field) {
            $fieldMethod = $authorMethod . ucfirst($field) . 's';
            $dataFieldValues[$field] = $this->tryMethod($fieldMethod, [], []);
        }

        // Match up author and attribute data (this assumes that the attribute
        // arrays have the same indices as the author array; i.e. $author[$i]
        // has $dataFieldValues[$attribute][$i].
        foreach ($authors as $i => $author) {
            if (!isset($data[$author])) {
                $data[$author] = [];
            }

            foreach ($dataFieldValues as $field => $dataFieldValue) {
                if (!empty($dataFieldValue[$i])) {
                    // IxTheo: Field can have multiple values (e.g. secondary author roles)
                    if (!isset($data[$author][$field]))
                        $data[$author][$field] = [];
                    if (is_array($dataFieldValue[$i])) {
                        $data[$author][$field] = array_merge($data[$author][$field], $dataFieldValue[$i]);
                    } else {
                        $data[$author][$field][] = $dataFieldValue[$i];
                    }
                }
            }
        }

        return $data;
    }

    // Replaces any occurrences of "v.Chr." in $s w/ the version for the currently selected user-interface language.
    static private function MapBeforeChrist(string $s): string {
        static $lang_code = this->tuefind()->getTranslatorLocale();
        static $lang_code_to_bc_abbreviations_map = [
            "en" => "BC",
            "de" => "v.Chr.",
            "fr" => "avant J.-C.",
            "it" => "a.C.",
            "cn" => "公元前"
        ];
        $bc_abbreviation = $lang_code_to_bc_abbreviations_map[$lang_code] ?? null;
        if ($bc_abbreviation === null)
            return $s;
        return str_replace("v.Chr.", $bc_abbreviation, $s);
    }

    /**
     * Get corporation.
     *
     * @return array
     */
    public function getCorporation()
    {
        return isset($this->fields['corporation']) ?
            $this->fields['corporation'] : [];
    }


    private static function IntDiv($numerator, $denominator)
    {
        return (int)($numerator / $denominator);
    }

    private static function HasChapter($code)
    {
        return ($code % 1000000 != 999999) && ((self::IntDiv($code, 1000) % 1000) != 0);
    }

    private static function HasVerse($code)
    {
        return ($code % 1000000 != 999999) && (($code % 1000) != 0);
    }

    private static function GetBookCode($code)
    {
        return self::IntDiv($code, 1000000);
    }

    private static function GetChapter($code)
    {
        return self::IntDiv($code, 1000) % 1000;
    }

    private static function GetVerse($code)
    {
        return $code % 1000;
    }

    private static $codes_to_book_abbrevs = array(
        1 => "Mt",
        2 => "Mk",
        3 => "Lk",
        4 => "Jn",
        5 => "Acts",
        6 => "Rom",
        7 => "1 Cor",
        8 => "2 Cor",
        9 => "Gal",
        10 => "Eph",
        11 => "Phil",
        12 => "Col",
        13 => "1 Thess",
        14 => "2 Thess",
        15 => "1 Tim",
        16 => "2 Tim",
        17 => "Titus",
        18 => "Philemon",
        19 => "Heb",
        20 => "Jas",
        21 => "1 Pet",
        22 => "2 Pet",
        23 => "1 Jn",
        24 => "2 Jn",
        25 => "3 Jn",
        26 => "Jude",
        27 => "Rev",
        28 => "Gen",
        29 => "Ex",
        30 => "Lev",
        31 => "Num",
        32 => "Deut",
        33 => "Josh",
        34 => "Judg",
        35 => "Ruth",
        36 => "1 Sam",
        37 => "2 Sam",
        38 => "1 Kings",
        39 => "2 Kings",
        40 => "1 Chr",
        41 => "2 Chr",
        42 => "Ezra",
        43 => "Neh",
        44 => "Esth",
        45 => "Job",
        46 => "Ps",
        47 => "Prov",
        48 => "Eccl",
        49 => "Song",
        50 => "Isa",
        51 => "Jer",
        52 => "Lam",
        53 => "Ezek",
        54 => "Dan",
        55 => "Hos",
        56 => "Joel",
        57 => "Am",
        58 => "Obadiah",
        59 => "Jon",
        60 => "Mic",
        61 => "Nah",
        62 => "Hab",
        63 => "Zeph",
        64 => "Hag",
        65 => "Zech",
        66 => "Mal",
        67 => "3 Ezra",
        68 => "4 Ezra",
        69 => "1 Macc",
        70 => "2 Macc",
        71 => "3 Macc",
        72 => "4 Macc",
        73 => "Tob",
        74 => "Jdt",
        75 => "Bar",
        77 => "Sir",
        78 => "Wis",
        81 => "6 Macc",
        82 => "5 Ezra",
        83 => "6 Ezra",
        84 => "",
        85 => "",
    );

    private static $CodesToCodexTitles = [  1 => 'CIC1917',
                                            2 => 'CIC1983',
                                            3 => 'CCEO',
    ];

    private static function DecodeBookCode($book_code, $separator)
    {
        $book_code_as_string = self::$codes_to_book_abbrevs[self::GetBookCode($book_code)];
        if (!self::HasChapter($book_code))
            return $book_code_as_string;
        $book_code_as_string .= " " . strval(self::GetChapter($book_code));
        if (!self::HasVerse($book_code))
            return $book_code_as_string;
        return $book_code_as_string . $separator . strval(self::GetVerse($book_code));
    }

    private static function DecodeChapterVerse($book_code, $separator)
    {
        $chapter_code_as_string = "";

        if (!self::HasChapter($book_code))
            return $chapter_code_as_string;
        $chapter_code_as_string .= strval(self::GetChapter($book_code));
        if (!self::HasVerse($book_code))
            return $chapter_code_as_string;
        $verse = self::GetVerse($book_code);
        if ($verse != 0 && $verse != 999)
            return $chapter_code_as_string . $separator . strval(self::GetVerse($book_code));
        else
            return $chapter_code_as_string;
    }

    private static function BibleRangeToDisplayString($bible_range, $language_code)
    {
        $separator = (substr($language_code, 0, 2) == "de") ? "," : ":";
        $code1 = (int)substr($bible_range, 0, 8);
        $code2 = (int)substr($bible_range, 9, 8);

        if ($code1 + 999999 == $code2)
            return self::DecodeBookCode($code1, $separator);
        if (self::GetBookCode($code1) != self::GetBookCode($code2))
            return self::DecodeBookCode($code1, $separator) . " – " . self::DecodeBookCode($code2, $separator);

        $codes_as_string = self::$codes_to_book_abbrevs[self::GetBookCode($code1)] . " ";
        $chapter1 = self::GetChapter($code1);
        $chapter2 = self::GetChapter($code2);

        if ($chapter1 == $chapter2) {
            $codes_as_string .= strval($chapter1);
            $verse1 = self::GetVerse($code1);
            $verse2 = self::GetVerse($code2);
            if ($verse1 == $verse2)
                return $codes_as_string . $separator . strval($verse1);
            elseif ($verse1 == 0 && $verse2 == 999)
                return $codes_as_string;
            else
                return $codes_as_string . $separator . strval($verse1) . "–" . strval($verse2);
        }
        return $codes_as_string . self::DecodeChapterVerse($code1, $separator) . "–" . self::DecodeChapterVerse($code2, $separator);
    }

    private static function CanonLawRangePartToArray($canonLawRangePart): array
    {
        // see also: https://github.com/ubtue/tuefind/wiki/Codices
        if (strlen($canonLawRangePart) != 9)
            throw new \Exception('Invalid canon law range part: ' . $canonLawRangePart);

        $codexId = $canonLawRangePart[0];
        $codexTitle = self::$CodesToCodexTitles[$codexId] ?? null;
        if ($codexTitle === null)
            throw new \Exception('Invalid codex id: ' . $codexId);

        return ['codexId' => $codexId,
                'codexTitle' => $codexTitle,
                'canon' => intval(substr($canonLawRangePart, 1, 4)),
                'pars1' => intval(substr($canonLawRangePart, 5, 2)),
                'pars2' => intval(substr($canonLawRangePart, 7, 2)),
        ];
    }

    private static function CanonLawRangeToDisplayString($canonLawRange): string
    {
        list ($canonLawRangeStart, $canonLawRangeEnd) = explode('_', $canonLawRange);
        $canonLawRangeStart = self::CanonLawRangePartToArray($canonLawRangeStart);
        $canonLawRangeEnd = self::CanonLawRangePartToArray($canonLawRangeEnd);

        $displayString = $canonLawRangeStart['codexTitle'];

        if ($canonLawRangeStart['canon'] == 0 && $canonLawRangeEnd['canon'] == 9999)
            return $displayString;
        $displayString .= ' ' . $canonLawRangeStart['canon'];

        if ($canonLawRangeStart['pars1'] . $canonLawRangeStart['pars2'] != 0)
            $displayString .= $canonLawRangeStart['pars1'] . ',' . $canonLawRangeStart['pars2'];

        if ($canonLawRangeStart['canon'] != $canonLawRangeEnd['canon'] || $canonLawRangeEnd['pars1'] . $canonLawRangeEnd['pars2'] != 9999) {
            $displayString .= '-';
            if ($canonLawRangeStart['canon'] != $canonLawRangeEnd['canon'])
                $displayString .= $canonLawRangeEnd['canon'];
            if ($canonLawRangeEnd['pars1'] . $canonLawRangeEnd['pars2'] != 9999)
                $displayString .= $canonLawRangeEnd['pars1'] . ',' . $canonLawRangeEnd['pars2'];
        }

        return $displayString;
    }

    public function getBibleRangesString()
    {
        if (!isset($this->fields['bible_ranges']))
            return "";
        $language_code = $this->getTranslatorLocale();
        $bible_references = "";
        foreach (explode(',', $this->fields['bible_ranges']) as $bible_range) {
            if (!empty($bible_references))
                $bible_references .= ", ";
            $bible_references .= self::BibleRangeToDisplayString($bible_range, $language_code);
        }
        return $bible_references;
    }

    public function getBundleIds(): array
    {
        return $this->fields['bundle_id'] ?? [];
    }

    public function getCanonLawRangesStrings(): array
    {
        $canonLawRanges = $this->fields['canon_law_ranges'] ?? null;
        if ($canonLawRanges === null)
            return [];

        $canonLawRanges = explode(',', $canonLawRanges);
        $canonLawRangesStrings = [];
        foreach ($canonLawRanges as $canonLawRange) {
            $canonLawRangesStrings[] = self::CanonLawRangeToDisplayString($canonLawRange);
        }
        sort($canonLawRangesStrings);
        return $canonLawRangesStrings;
    }

    public function getKeyWordChainBag()
    {
        return isset($this->fields['key_word_chain_bag']) ?
            $this->fields['key_word_chain_bag'] : '';
    }

    public function getPrefix4KeyWordChainBag()
    {
        return isset($this->fields['prefix4_key_word_chain_bag']) ?
            $this->fields['prefix4_key_word_chain_bag'] : '';
    }

    /**
     * Check whether there are fulltexts associated with this record
     * @return bool
     */
    public function hasFulltext()
    {
        return isset($this->fields['has_fulltext']) && $this->fields['has_fulltext'] == true;
    }

    public function isAvailableForPDA()
    {
        return isset($this->fields['is_potentially_pda']) && $this->fields['is_potentially_pda'];
    }
}
