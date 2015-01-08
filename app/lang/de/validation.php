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

	"accepted"             => ":attribute muss akzeptiert werden.",
	"active_url"           => ":attribute ist keine gültige URL.",
	"after"                => ":attribute muss ein Datum nach :date sein.",
	"alpha"                => ":attribute darf nur Buchstaben enthalten.",
	"alpha_dash"           => ":attribute darf nur Buchstaben, Nummern und Bindestriche enthalten.",
	"alpha_num"            => ":attribute darf nur Buchstaben und Nummern enthalten.",
	"array"                => ":attribute muss eine Liste sein.",
	"before"               => ":attribute muss ein Datum vor :date sein.",
	"between"              => array(
		"numeric" => ":attribute muss zwichen :min und :max liegen.",
		"file"    => ":attribute muss zwischen :min und :max Kilobyte groß sein.",
		"string"  => ":attribute muss zwischen :min und :max Zeichen enthalten.",
		"array"   => ":attribute muss mindestens :min und maximal :max Einträge enhalten.",
	),
	"boolean"              => ":attribute muss wahr oder falsch sein.",
	"confirmed"            => ":attribute Wiederholung stimmt nicht überein.",
	"date"                 => ":attribute ist kein gültiges Datum.",
	"date_format"          => ":attribute entspricht nicht dem Format :format.",
	"different"            => ":attribute und :other müssen sich unterscheiden.",
	"digits"               => ":attribute müssen :digits Ziffern sein.",
	"digits_between"       => ":attribute müssen zwischen :min und :max Ziffern sein.",
	"email"                => ":attribute muss eine gültige E-Mail-Adresse sein.",
	"exists"               => "Die Selektion von :attribute ist ungültig.",
	"image"                => ":attribute muss ein Bild sein.",
	"in"                   => "Die Selektion von :attribute ist ungültig.",
	"integer"              => ":attribute muss eine Ganzzahl sein.",
	"ip"                   => ":attribute muss eine gültige IP-Adresse sein.",
	"max"                  => array(
		"numeric" => ":attribute darf nicht größer als :max sein.",
		"file"    => ":attribute darf nicht größer als :max Kilobyte sein.",
		"string"  => ":attribute darf nicht mehr als :max Zeichen enthalten.",
		"array"   => ":attribute darf nicht mehr als :max Einträge enthalten.",
	),
	"mimes"                => ":attribute muss einem der folgenden Typen entsprechen: :values.",
	"min"                  => array(
		"numeric" => ":attribute darf nicht kleiner als :max sein.",
		"file"    => ":attribute darf nicht kleiner als :max Kilobyte sein.",
		"string"  => ":attribute darf nicht weniger als :max Zeichen enthalten.",
		"array"   => ":attribute darf nicht weniger als :max Einträge enthalten.",
	),
	"not_in"               => "Die Selektion von :attribute ist ungültig.",
	"numeric"              => ":attribute muss eine Zahl sein.",
	"regex"                => ":attribute hat ein unültiges Format.",
	"required"             => ":attribute ist verpflichtend.",
	"required_if"          => ":attribute ist verpflichtend wenn :other ist :value.",
	"required_with"        => ":attribute ist verpflichtend wenn :values gegeben ist.",
	"required_with_all"    => ":attribute ist verpflichtend wenn :values gegeben ist.",
	"required_without"     => ":attribute ist verpflichtend wenn :values nicht gegeben ist.",
	"required_without_all" => ":attribute ist verpflichtend wenn keine von :values gegeben ist.",
	"same"                 => ":attribute und :other müssen übereinstimmen.",
	"size"                 => array(
		"numeric" => ":attribute muss :size sein.",
		"file"    => ":attribute muss :size Kilobyte groß sein.",
		"string"  => ":attribute muss :size Zeichen enthalten.",
		"array"   => ":attribute muss :size Einträge enthalten.",
	),
	"unique"               => ":attribute muss einmalig sein oder wird bereits genutzt",
	"url"                  => ":attribute ist keine gültige URL.",
	"timezone"             => ":attribute muss eine gültige Zeitzone sein.",
	"check_hash"			=> ":attribute ist nicht gültig.",
	"check_language"        => "Die gewählte Sprache wird nicht unterstützt.",
	"geometry"				=> "Das gegebene geometrische Objekt ist ungültig.",
	"date8601"				=> "Das gegebene Datum ist nach ISO 8601 nicht gültig.",

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
