<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Title;
use TheIconic\NameParser\Part\LastnamePrefix;

/**
 * A generic mapper for name parts that consist of
 * multiple words (components)
 * This affects in Germany for example lastname prefixes
 * and (academic) titles, which are often consisting
 * of several words
 * See describing samples in: \Language\German.php:
 * LASTNAME_PREFIXES[], TITLES_DR[], OFFICIAL_TITLES[]
 * and JOB_TITLES[]
 *
 * @author Volker Püschel <kuffy@anasco.de>
 * @copyright 2019 Volker Püschel
 * @license MIT
 */

class MultipartMapper extends AbstractMapper
{
    protected $samples = [];
    protected $sampleType;
    protected $className;

    public function __construct(array $samples, string $sampleType)
    {
        $this->sampleType = $sampleType;

        if (strtolower($sampleType) == 'prefix') {
            $this->className = 'TheIconic\\NameParser\\Part\\Lastname' . ucfirst($sampleType);
        } else {
            $this->className = 'TheIconic\\NameParser\\Part\\' . ucfirst($sampleType);
        }

        $values = [];

        $samples = $this->sortArrayDescending($samples);
        foreach ($samples as $key => $sample) {       // fragmentation of the strings into words or abbreviations
            $fragments = explode(' ', $sample);
            $values[$key][$sampleType] = $sample;
            $values[$key]['fragments'] = $fragments;
            $values[$key]['number'] = count($fragments);
        }
        $this->samples = $values;
    }

    /**
     * map composite name components in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        $className = $this->className;
        $countParts = count($parts);
        foreach ($this->samples as $sample) {
            if ($sample['number'] >= $countParts + 1) {      // assumption: minimum composite of name parts and the lastname
                continue;
            }
            $mappedParts = [];
            foreach ($sample['fragments'] as $fragment) {
                $result = array_search($fragment, $parts);
                if ($result !== false) {
                    $mappedParts[] = $result;
                } else {
                    continue(2);
                }
            }
            foreach ($mappedParts as $key) {
                if ($parts[$key] instanceof AbstractPart) {
                    break;
                }
                $parts[$key] = new $className($parts[$key]);
            }

            return $parts;
        }

        return $parts;
    }

    /**
     * get sampleType
     *
     * @return string
     */
    public function getSampleType()
    {
        return $this->sampleType;
    }
}
