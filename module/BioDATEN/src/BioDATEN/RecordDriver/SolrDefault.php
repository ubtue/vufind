<?php

namespace BioDATEN\RecordDriver;

/**
 * Omitted so far / trying to re-use standard fields:
 * - id (+uuid)
 * - title
 */
class SolrDefault extends \VuFind\RecordDriver\SolrDefault
{
    public function getAccessRight()
    {
        return $this->fields['access_right'] ?? '';
    }

    public function getBwCluster()
    {
        return $this->fields['bwCluster'] ?? '';
    }

    public function getCellType()
    {
        return $this->fields['cell_type'] ?? '';
    }

    public function getChecksum()
    {
        return $this->fields['checksum'] ?? '';
    }

    public function getCopyright()
    {
        return $this->fields['copyright'] ?? '';
    }

    public function getCreationDate()
    {
        return $this->fields['creation_date'] ?? '';
    }

    public function getCreator()
    {
        return $this->fields['creator'] ?? '';
    }

    public function getDescriptions()
    {
        return $this->fields['description'] ?? [];
    }

    public function getDiscipline()
    {
        return $this->fields['discipline'] ?? '';
    }

    public function getExperimentType()
    {
        return $this->fields['experiment_type'] ?? '';
    }

    public function getFile()
    {
        return $this->fields['file'] ?? '';
    }

    public function getFileLocation()
    {
        return $this->fields['file_location'] ?? '';
    }

    public function getFileName()
    {
        return $this->fields['file_name'] ?? '';
    }

    public function getFileSize()
    {
        return $this->fields['file_size'] ?? '';
    }

    public function getFileType()
    {
        return $this->fields['file_type'] ?? '';
    }

    public function getInstitution()
    {
        return $this->fields['institution'] ?? '';
    }

    public function getJobId()
    {
        return $this->fields['job_Id'] ?? '';
    }

    public function getJobCompleted()
    {
        // Intentional typo
        return $this->fields['job_comleted'] ?? '';
    }

    public function getJobStarted()
    {
        return $this->fields['job_started'] ?? '';
    }

    public function getKeywords()
    {
        return $this->fields['keyword'] ?? [];
    }

    public function getLastModified()
    {
        return $this->fields['last_modified'] ?? '';
    }

    public function getLicense()
    {
        return $this->fields['license'] ?? '';
    }

    public function getMetsDocumentId()
    {
        return $this->fields['mets_document_ID'] ?? '';
    }

    public function getOrcids()
    {
        return $this->fields['orcid'] ?? [];
    }

    public function getOrgan()
    {
        return $this->fields['organ'] ?? '';
    }

    public function getOrganism()
    {
        return $this->fields['organism'] ?? '';
    }

    public function getPlatform()
    {
        return $this->fields['platform'] ?? '';
    }

    public function getProject()
    {
        return $this->fields['project'] ?? '';
    }

    public function getResourceType()
    {
        return $this->fields['resource_type'] ?? '';
    }

    public function getSampleType()
    {
        return $this->fields['sample_type'] ?? '';
    }

    public function getStudyType()
    {
        return $this->fields['study_type'] ?? '';
    }

    public function getText()
    {
        return $this->fields['text'] ?? '';
    }
}
