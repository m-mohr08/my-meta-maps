<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => ":attribute moet accepteert worden",
	"active_url"           => ":attribute is geen valide URL.",
	"after"                => ":attribute moet een datum evenals :date zijn.",
	"alpha"                => ":attribute mag alleen letters inhouden.",
	"alpha_dash"           => ":attribute mag alleen letters, nummers en streepjes inhouden.",
	"alpha_num"            => ":attribute mag alleen letters en nummers inhouden.",
	"array"                => ":attribute moet een lijst zijn.",
	"before"               => ":attribute moet een datum voordat :date zijn.",
	"between"              => array(
		"numeric" => ":attribute moet tussen :min en :max liggen.",
		"file"    => ":attribute moet tussen :min en :max kilobyte groot zijn.",
		"string"  => ":attribute moet tussen :min en :max teken inhouden.",
		"array"   => ":attribute moet minstens :min en maximaal :max records inhouden.",
	),
	"boolean"              => ":attribute moet waar of fout zijn.",
	"confirmed"            => ":attribute herhaling stemmt niet overeen.",
	"date"                 => ":attribute is geen valide datum.",
	"date_format"          => ":attribute is niet in het formaat :format.",
	"different"            => ":attribute en :other moeten zich onderscheiden.",
	"digits"               => ":attribute moeten :digits cijfers zijn.",
	"digits_between"       => ":attribute moeten tussen :min en :max cijfers zijn.",
	"email"                => ":attribute moet een valide e-mailadres zijn.",
	"exists"               => "De selectie van :attribute is niet geldig.",
	"image"                => ":attribute moet een beeld zijn.",
	"in"                   => "De selectie van :attribute is niet geldig.",
	"integer"              => ":attribute moet een geheel getal zijn.",
	"ip"                   => ":attribute moet een valide IP-adres zijn.",
	"max"                  => array(
		"numeric" => ":attribute mag niet groter zijn dan :max.",
		"file"    => ":attribute mag niet groter zijn dan :max kilobytes.",
		"string"  => ":attribute mag niet meer dan :max teken inhouden.",
		"array"   => ":attribute mag niet meer dan :max records inhouden.",
	),
	"mimes"                => ":attribute moet met een van de volgende typen overeenstemmen: :values",
	"min"                  => array(
		"numeric" => ":attribute mag niet kleiner zijn dan :min.",
		"file"    => ":attribute mag niet kleiner zijn dan :min kilobytes.",
		"string"  => ":attribute moet minstens :min teken inhouden.",
		"array"   => ":attribute moet minstens :min records inhouden.",
	),
	"not_in"               => "De selectie van :attribute is niet geldig.",
	"numeric"              => ":attribute moet een nummer zijn.",
	"regex"                => ":attribute formaat is niet geldig.",
	"required"             => ":attribute is verplichtend.",
	"required_if"          => ":attribute is verplichtend wanneer :other is :value.",
	"required_with"        => ":attribute is verplichtend wanneer :values is gegeven.",
	"required_with_all"    => ":attribute is verplichtend wanneer :values is gegeven.",
	"required_without"     => ":attribute is verplichtend wanneer :values is niet gegeven.",
	"required_without_all" => ":attribute is verplichtend wanneer geen van de :values is gegeven",
	"same"                 => ":attribute en :other moeten overeenstemmen.",
	"size"                 => array(
		"numeric" => ":attribute moet :size zijn.",
		"file"    => ":attribute moet :size kilobytes groot zijn.",
		"string"  => ":attribute moet :size teken inhouden.",
		"array"   => ":attribute moet :size records inhouden.",
	),
	"unique"               => ":attribute is reeds in gebruik.",
	"url"                  => ":attribute is geen valide URL.",
	"timezone"             => ":attribute moet een valide tijdzone zijn.",
	"check_hash"            => ":attribute is niet geldig.",
	"check_language"        => "De gekozen taal wordt niet ondersteunt.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
