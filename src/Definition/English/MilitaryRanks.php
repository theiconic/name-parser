<?php

namespace TheIconic\NameParser\Definition\English;

use TheIconic\NameParser\DefinitionInterface;

class MilitaryRanks implements DefinitionInterface
{
    const SALUTATIONS = [
        '1sg' => '1stSgt.',
        '1stsgt' => '1stSgt.',
        'a1c' => 'A1C',
        'ab' => 'AB',
        'adm' => 'Adm.',
        'amn' => 'Amn.',
        'ccm' => 'CCM',
        'cdt' => 'Cdt.',
        'cmc' => 'CMC',
        'cmd' => 'Cmd.',
        'cmsaf' => 'CMSAF',
        'cmsgt' => 'CMSgt',
        'cpl' => 'Cpl.',
        'cpo' => 'CPO',
        'cpt' => 'Cpt.',
        'cptn' => 'Cpt.',
        'csm' => 'CSM',
        'ens' => 'Ens.',
        'esn' => 'Ens.',
        'fadm' => 'FAdm.',
        'flt' => '1stLt.',
        'fltmc' => 'FLTMC',
        'formc' => 'FORMC',
        'gen' => 'Gen.',
        'gysgt' => 'GySgt.',
        'lcpl' => 'LCpl.',
        'ltcmd' => 'LtCmd.',
        'ltgen' => 'LtGen.',
        'maj' => 'Maj.',
        'majgen' => 'MajGen.',
        'mcpo' => 'MCPO',
        'mcpo-cg' => 'MCPO-CG',
        'mcpon' => 'MCPON',
        'mgysgt' => 'MGySgt.',
        'msg' => 'MSgt.',
        'msgt' => 'MSgt.',
        'ocdt' => 'OCdt.',
        'pfc' => 'PFC',
        'po1' => 'PO1',
        'po2' => 'PO2',
        'po3' => 'PO3',
        'pv1' => 'Pvt.',
        'pv2' => 'Pvt.',
        'pvt' => 'Pvt.',
        'radm' => 'RAdm.',
        'sa' => 'SA',
        'scpo' => 'SCPO',
        'sfc' => 'SFC',
        'sgm' => 'SgtMaj.',
        'sgt' => 'Sgt.',
        'sgtmaj' => 'SgtMaj.',
        'sgtmajmc' => 'SgtMajMC',
        'slt' => '2ndLt.',
        'sma' => 'SMA',
        'smsgt' => 'SMSgt.',
        'sn' => 'Sn.',
        'spc' => 'Spc.',
        'sra' => 'SrA',
        'ssg' => 'SSgt.',
        'ssgt' => 'SSgt.',
        'tsgt' => 'TSgt.',
        'vadm' => 'VAdm.',
    ];

    const SUFFIXES = [
        '1sg' => '1SG',
        '1stsgt' => '1SG',
        'a1c' => 'A1C',
        'ab' => 'AB',
        'adm' => 'ADM',
        'amn' => 'AMN',
        'ccm' => 'CCM',
        'cdt' => 'CDT',
        'cmc' => 'CMC',
        'cmd' => 'CMD',
        'cmsaf' => 'CMSAF',
        'cmsgt' => 'CMSGT',
        'cpl' => 'CPL',
        'cpo' => 'CPO',
        'cpt' => 'CPT',
        'cptn' => 'CPT',
        'csm' => 'CSM',
        'ens' => 'ENS',
        'esn' => 'ENS',
        'fadm' => 'FADM',
        'flt' => '1LT',
        'fltmc' => 'FLTMC',
        'formc' => 'FORMC',
        'gen' => 'GEN',
        'gysgt' => 'GYSGT',
        'lcpl' => 'LCPL',
        'ltcmd' => 'LTCMD',
        'ltgen' => 'LTGEN',
        'maj' => 'MAJ',
        'majgen' => 'MAJGEN',
        'mcpo' => 'MCPO',
        'mcpo-cg' => 'MCPO-CG',
        'mcpon' => 'MCPON',
        'mgysgt' => 'MGYSGT',
        'msg' => 'MSGT',
        'msgt' => 'MSGT',
        'ocdt' => 'OCDT',
        'pfc' => 'PFC',
        'po1' => 'PO1',
        'po2' => 'PO2',
        'po3' => 'PO3',
        'pv1' => '1PV',
        'pv2' => '2PV',
        'pvt' => 'PVT',
        'radm' => 'RADM',
        'sa' => 'SA',
        'scpo' => 'SCPO',
        'sfc' => 'SFC',
        'sgm' => 'SGTMAJ',
        'sgt' => 'SGT',
        'sgtmaj' => 'SGTMAJ',
        'sgtmajmc' => 'SGTMAJMC',
        'slt' => '2LT',
        'sma' => 'SMA',
        'smsgt' => 'SMSGT',
        'sn' => 'SN',
        'spc' => 'SPC',
        'sra' => 'SRA',
        'ssg' => 'SSGT',
        'ssgt' => 'SSGT',
        'tsgt' => 'TSGT',
        'vadm' => 'VADM',
    ];

    const LASTNAME_PREFIXES = [];

    public function getSuffixes(): array
    {
        return self::SUFFIXES;
    }

    public function getSalutations(): array
    {
        return self::SALUTATIONS;
    }

    public function getLastnamePrefixes(): array
    {
        return self::LASTNAME_PREFIXES;
    }
}
