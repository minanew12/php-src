--TEST--
IntlRuleBasedBreakIterator::getBinaryRules(): basic test icu >= 61.1 && icu < 68.1
--EXTENSIONS--
intl
--SKIPIF--
<?php if(version_compare(INTL_ICU_VERSION, '61.1') < 0) print 'skip for ICU >= 61.1'; ?>
<?php if (version_compare(INTL_ICU_VERSION, '68.1') >= 0) die('skip for ICU < 68.1'); ?>
--FILE--
<?php
ini_set("intl.error_level", E_WARNING);
ini_set("intl.default_locale", "pt_PT");

$rules = <<<RULES
\$LN = [[:letter:] [:number:]];
\$S = [.;,:];

!!forward;
\$LN+ {1};
\$S+ {42};
!!reverse;
\$LN+ {1};
\$S+ {42};
!!safe_forward;
!!safe_reverse;
RULES;
$rbbi = new IntlRuleBasedBreakIterator($rules);
$rbbi->setText('sdfkjsdf88á.... ,;');

$br = $rbbi->getBinaryRules();

$rbbi2 = new IntlRuleBasedBreakIterator($br, true);

var_dump($rbbi->getRules(), $rbbi2->getRules());
var_dump($rbbi->getRules() == $rbbi2->getRules());
?>
--EXPECT--
string(137) "$LN = [[:letter:] [:number:]];
$S = [.;,:];
!!forward;
$LN+ {1};
$S+ {42};
!!reverse;
$LN+ {1};
$S+ {42};
!!safe_forward;
!!safe_reverse;"
string(137) "$LN = [[:letter:] [:number:]];
$S = [.;,:];
!!forward;
$LN+ {1};
$S+ {42};
!!reverse;
$LN+ {1};
$S+ {42};
!!safe_forward;
!!safe_reverse;"
bool(true)
