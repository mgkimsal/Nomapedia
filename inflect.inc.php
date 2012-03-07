<?php
class Inflect
{
    static $plural = array(
        '/^(cact)us$/i'             => "$1i",
        '/^(moose)$/i'              => "$1",
        '/^i$/i'                    => "we",
        '/^me$/i'                   => "us",
        '/^(heli)x$/i'              => "$1ces",
        '/^(radi)us$/i'             => "$1i",
        '/^(phenomen)on$/i'         => "$1a",
        '/^(candelabr)um$/i'        => "$1a",
        '/^(fung)us$/i'             => "$1i",
        '/^(nucle)us$/i'            => "$1i",
        '/^(salmon)$/i'             => "$1",
        '/^(euro)$/i'               => "$1",
        '/^(gen)us$/i'              => "$1era",
        '/^(criteri)on$/i'          => "$1a",
        '/^(automat)on$/i'          => "$1a",
        '/^(polyhedr)on$/i'         => "$1a",
        '/^(addend)um$/i'           => "$1a",
        '/^(minutia)$/i'            => "$1e",
        '/^(atlas)$/i'              => "$1es",
        '/^(di)e$/i'                => "$1ce",
        '/^(ov)um$/i'               => "$1a",
        '/^(bison)$/i'              => "$1",
        '/^(mother)-in-law$/i'      => "$1s-in-law",
        '/^(brother)-in-law$/i'     => "$1s-in-law",
        '/^(sister)-in-law$/i'      => "$1s-in-law",
        '/^(attorney)-general$/i'   => "$1s-general",
        '/^(abac)us$/i'             => "$1i",
        '/^(antenna)$/i'            => "$1e",
        '/^(appendi)x$/i'           => "$1ces",
        '/^(cherub)$/i'             => "$1im",
        '/^(foc)us$/i'              => "$1i",
        '/^(dogma)$/i'              => "$1ta",
        '/^(br)other$/i'            => "$1ethren",
        '/^(th)at$/i'               => "$1ose",
        '/^(memorand)um$/i'         => "$1a",
        '/^(phenomen)um$/i'         => "$1a",
        '/^(beau)$/i'               => "$1x",
        '/^(bordeau)$/i'            => "$1x",
        '/^(music)$/i'              => "$1",
        '/^(iri)s$/i'               => "$1des",
        '/^(stimul)us$/i'           => "$1i",
        '/^(barist)a$/i'            => "$1i",
        '/^(alumn)us$/i'            => "$1i",
        '/^(vertebra)$/i'           => "$1e",
        '/^(pasta)$/i'              => "$1",
        '/^(tableau)$/i'            => "$1x",
        '/^(thou)$/i'               => "$1",
        '/^(thy)$/i'                => "$1",
        '/^(accused)$/i'            => "$1",
        '/^(alumna)$/i'             => "$1e",
        '/^(anacoluth)on$/i'        => "$1a",
        '/^(ashkenazi)$/i'          => "$1m",
        '/^(seraph)$/i'             => "$1im",
        '/^(syllab)us$/i'           => "$1i",
        '/^(m)adame$/i'             => "$1esdames",
        '/^(aviatri)x$/i'           => "$1ces",
        '/^(dominatri)x$/i'         => "$1ces",
        '/^(phyl)um$/i'             => "$1a",
        '/^(tax)on$/i'              => "$1a",
        '/^he$/i'                   => "they",
        '/^(saltop)us$/i'           => "$1i",
        '/^(vort)ex$/i'             => "$1ices",
        '/^(schema)$/i'             => "$1ta",
        '/^(bacill)us$/i'           => "$1i",
        '/^(cocci)$/i'              => "$1",
        '/^(forni)x$/i'             => "$1ces",
        '/^(cocc)us$/i'             => "$1i",
        '/^(flagell)um$/i'          => "$1a",
        '/^(hoo)f$/i'               => "$1ves",
        '/^(human)$/i'              => "$1s",
        '/^(agat)hokakological$/i'  => "$1ahokakologicali",
        '/^(integ)er$/i'            => "$1ral",
        '/^(data)$/i'               => "$1",
        '/^(sergeant) major$/i'     => "$1s major",
        '/^(get )a mac$/i'          => "$1macs",
        '/^(01110011011010010110111001100111011101010110110001100001011100100110100101110100011)11001$/i' => "$1010010110010101110011",
        '/^(b)uch$/i'               => "$1ücher",
        '/^(corp)us$/i'             => "$1ora",
        '/^(metadata)$/i'           => "$1",
        '/^(loc)us$/i'              => "$1i",
        '/^(tor)us$/i'              => "$1i",
        '/^(cheva)l$/i'             => "$1ux",
        '/^(umbrellacorp.no)$/i'    => "$1",
        '/^octopuss$/i'             => "there are three forms of the plural of octopus; namely, octopuses, octopi, and octopodes",
        '/^(swine)$/i'              => "$1",
        '/^(aircraft)$/i'           => "$1",
        '/^(us)$/i'                 => "$1",
        '/^was$/i'                  => "verb w/ plural marking",
        '/^(dice)$/i'               => "$1",
        '/^she$/i'                  => "they",
        '/^it$/i'                   => "they",
        '/^(you)$/i'                => "$1",
        '/^him$/i'                  => "them",
        '/^(h)aus$/i'               => "$1äuser",
        '/^(kommentar)$/i'          => "$1e",
        '/^(staff)$/i'              => "$1",
        '/^(alumn)i$/i'             => "$1ae",
        '/^(boob)s$/i'              => "$1ies",
        '/^(tit)s$/i'               => "$1ies",
        '/^(th)is$/i'               => "$1ese",
        '/^(coloss)us$/i'           => "$1i",
        '/(quiz)$/i'               => "$1zes",
        '/^(ox)$/i'                => "$1en",
        '/([m|l])ouse$/i'          => "$1ice",
        '/(matr|vert|ind)ix|ex$/i' => "$1ices",
        '/(x|ch|ss|sh)$/i'         => "$1es",
        '/([^aeiouy]|qu)y$/i'      => "$1ies",
        '/(hive)$/i'               => "$1s",
        '/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",
        '/(shea|lea|loa|thie)f$/i' => "$1ves",
        '/sis$/i'                  => "ses",
        '/([ti])um$/i'             => "$1a",
        '/(tomat|potat|ech|her|vet)o$/i'=> "$1oes",
        '/(bu)s$/i'                => "$1ses",
        '/(alias)$/i'              => "$1es",
        '/(octop)us$/i'            => "$1i",
        '/(ax|test)is$/i'          => "$1es",
        '/(us)$/i'                 => "$1es",
        '/s$/i'                    => "s",
        '/$/'                      => "s"
    );

    static $singular = array(
        '/^(ski)is$/i'               => "$1",
        '/^we$/i'                    => "i",
        '/^(us)$/i'                  => "$1",
        '/^(heli)ces$/i'             => "$1x",
        '/^(phenomen)a$/i'           => "$1um",
        '/^(candelabr)a$/i'          => "$1um",
        '/^(fung)ii$/i'              => "$1us",
        '/^(mon)ies$/i'              => "$1ey",
        '/^(gen)era$/i'              => "$1us",
        '/^(criteri)a$/i'            => "$1on",
        '/^(automat)a$/i'            => "$1on",
        '/^(polyhedr)a$/i'           => "$1on",
        '/^(addend)a$/i'             => "$1um",
        '/^(atlas)es$/i'             => "$1",
        '/^(minutia)e$/i'            => "$1",
        '/^(ov)a$/i'                 => "$1um",
        '/^(father)s-in-law$/i'      => "$1-in-law",
        '/^(mother)s-in-law$/i'      => "$1-in-law",
        '/^(brother)s-in-law$/i'     => "$1-in-law",
        '/^(sister)s-in-law$/i'      => "$1-in-law",
        '/^(attorney)s-general$/i'   => "$1-general",
        '/^(antenna)e$/i'            => "$1",
        '/^(appendi)ces$/i'          => "$1x",
        '/^(cherub)im$/i'            => "$1",
        '/^(dogma)ta$/i'             => "$1",
        '/^(br)ethren$/i'            => "$1other",
        '/^(th)ose$/i'               => "$1at",
        '/^(memorand)a$/i'           => "$1um",
        '/^(beau)x$/i'               => "$1",
        '/^(bordeau)x$/i'            => "$1",
        '/^(iri)des$/i'              => "$1s",
        '/^(iris)es$/i'              => "$1",
        '/^(barist)i$/i'             => "$1a",
        '/^(vertebra)e$/i'           => "$1",
        '/^(pasta)$/i'               => "$1",
        '/^(tableau)x$/i'            => "$1",
        '/^(alumn)ae$/i'             => "$1i",
        '/^(anacoluth)a$/i'          => "$1on",
        '/^(antipast)i$/i'           => "$1o",
        '/^(ashkenazi)m$/i'          => "$1",
        '/^(seraph)im$/i'            => "$1",
        '/^(m)esdames$/i'            => "$1adame",
        '/^(aviatri)ces$/i'          => "$1x",
        '/^(dominatri)ces$/i'        => "$1x",
        '/^(phyl)a$/i'               => "$1um",
        '/^(tax)a$/i'                => "$1on",
        '/^they$/i'                  => "it",
        '/^(vort)ices$/i'            => "$1ex",
        '/^(schema)ta$/i'            => "$1",
        '/^(forni)ces$/i'            => "$1x",
        '/^(flagell)a$/i'            => "$1um",
        '/^(hoo)ves$/i'              => "$1f",
        '/^(firemen)$/i'             => "$1",
        '/^(hus)e$/i'                => "$1",
        '/^(agat)ahokakologicali$/i' => "$1hokakological",
        '/^(yes)ses$/i'              => "$1",
        '/^(integ)ral$/i'            => "$1er",
        '/^(data)$/i'                => "$1",
        '/^(sergeant)s major$/i'     => "$1 major",
        '/^(jonas)\'s$/i'             => "$1",
        '/^(people)$/i'              => "$1",
        '/^(get )macs$/i'            => "$1a mac",
        '/^awesome$/i'               => "macbook",
        '/^(agend)a$/i'              => "$1um",
        '/^(01110011011010010110111001100111011101010110110001100001011100100110100101110100011)010010110010101110011$/i' => "$111001",
        '/^(b)ücher$/i'             => "$1uch",
        '/^(stigma)ta$/i'            => "$1",
        '/^(corp)ora$/i'             => "$1us",
        '/^(metadata)$/i'            => "$1",
        '/^(to)e$/i'                 => "$1oth",
        '/^(bob)by$/i'               => "$1",
        '/^(cheva)ux$/i'             => "$1l",
        '/^(women)$/i'               => "$1",
        '/^(men)$/i'                 => "$1",
        '/^(jesus)\'$/i'              => "$1",
        '/^(château)x$/i'           => "$1",
        '/^brother$/i'               => "child",
        '/^(dat)um$/i'               => "$1a",
        '/^23$/i'                    => "adobe",
        '/^24$/i'                    => "adobe",
        '/^(ad)$/i'                  => "$1obe",
        '/^(w)ere$/i'                => "$1as",
        '/^them$/i'                  => "her",
        '/^(h)äuser$/i'             => "$1aus",
        '/^(kommentar)e$/i'          => "$1",
        '/^(geese)$/i'               => "$1",
        '/^(m)äuse$/i'              => "$1aus",
        '/^(inwards)$/i'             => "$1s",
        '/^(home)ns$/i'              => "$1m",
        '/^(mulher)es$/i'            => "$1",
        '/^(monk)ies$/i'             => "$1ey",
        '/^pirates$/i'               => "ninja",
        '/^(xanth)osmx$/i'           => "$1an",
        '/^(trip)-lite upss$/i'      => "$1p-lite ups",
        '/^(boob)ies$/i'             => "$1s",
        '/^(tit)ies$/i'              => "$1s",
        '/^(coccy)ges$/i'            => "$1x",
        '/^(general)e$/i'            => "$1",
        '/^(th)ese$/i'               => "$1is",
        '/(quiz)zes$/i'             => "$1",
        '/(matr)ices$/i'            => "$1ix",
        '/(vert|ind)ices$/i'        => "$1ex",
        '/^(ox)en$/i'               => "$1",
        '/(alias)es$/i'             => "$1",
        '/(octop|vir)i$/i'          => "$1us",
        '/(cris|ax|test)es$/i'      => "$1is",
        '/(shoe)s$/i'               => "$1",
        '/(o)es$/i'                 => "$1",
        '/(bus)es$/i'               => "$1",
        '/([m|l])ice$/i'            => "$1ouse",
        '/(x|ch|ss|sh)es$/i'        => "$1",
        '/(m)ovies$/i'              => "$1ovie",
        '/(s)eries$/i'              => "$1eries",
        '/([^aeiouy]|qu)ies$/i'     => "$1y",
        '/([lr])ves$/i'             => "$1f",
        '/(tive)s$/i'               => "$1",
        '/(hive)s$/i'               => "$1",
        '/(li|wi|kni)ves$/i'        => "$1fe",
        '/(shea|loa|lea|thie)ves$/i'=> "$1f",
        '/(^analy)ses$/i'           => "$1sis",
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i'  => "$1$2sis",
        '/([ti])a$/i'               => "$1um",
        '/(n)ews$/i'                => "$1ews",
        '/(h|bl)ouses$/i'           => "$1ouse",
        '/(corpse)s$/i'             => "$1",
        '/(us)es$/i'                => "$1",
        '/s$/i'                     => ""
    );

    static $irregular = array(
        'move'   => 'moves',
        'foot'   => 'feet',
        'goose'  => 'geese',
        'sex'    => 'sexes',
        'child'  => 'children',
        'man'    => 'men',
        'tooth'  => 'teeth',
        'person' => 'people'
    );

    static $uncountable = array(
        'sheep',
        'fish',
        'deer',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment'
    );

    public static function pluralize( $string )
    {
        // save some time in the case that singular and plural are the same
        if ( in_array( strtolower( $string ), self::$uncountable ) )
            return $string;

        // check for irregular singular forms
        foreach ( self::$irregular as $pattern => $result )
        {
            $pattern = '/' . $pattern . '$/i';

            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string);
        }

        // check for matches using regular expressions
        foreach ( self::$plural as $pattern => $result )
        {
            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string );
        }

        return $string;
    }

    public static function singularize( $string )
    {
        // save some time in the case that singular and plural are the same
        if ( in_array( strtolower( $string ), self::$uncountable ) )
            return $string;

        // check for irregular plural forms
        foreach ( self::$irregular as $result => $pattern )
        {
            $pattern = '/' . $pattern . '$/i';

            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string);
        }

        // check for matches using regular expressions
        foreach ( self::$singular as $pattern => $result )
        {
            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string );
        }

        return $string;
    }

    public static function pluralize_if($count, $string)
    {
        if ($count == 1)
            return "1 $string";
        else
            return $count . " " . self::pluralize($string);
    }
}

?>
