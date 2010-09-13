<?php
/*
Plugin Name: Simple Sex-Positive Glossary
Version: 0.1
Plugin URI: Wraps common terms with a link to a definition of that term. Built-in dictionary provides defaults for many sexuality-related phrases.
Description: Wraps common terms with a link to a definition of that term.
Author: Meitar "maymay" Moscovitz
Author URI: http://maybemaimed.com/

Copyright (c) 2010
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

This work is based off the WP Acronym Replacer plugin by Joel Bennett.
Joel's URI: http://www.HuddledMasses.org

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * function sexPositiveGlossaryTerm
 *
 * Given a string, finds and replaces all known terms with links pointing to a
 * page that provides their definition.
 *
 * @return string The replaced text.
 * @see http://www.maxprograms.com/articles/glossml.html
 */
function sexPositiveGlossaryTerm($text) {
    // First, we define all the things we're going to replace, without using parenthesis or pipes (|)
    // each deffinition is in the form: // "term" => "URL",
    // where URL is a fully-qualified link to a page where that term is defined.
    // For example:
    //         "afaik" => "http://www.acronymfinder.com/AFAIK.html",
    // ESPECIALLY note that they all end with commas EXCEPT the last one
    global $sexpositiveterm_sexpositiveterm;

    if (empty($sexpositiveterm_sexpositiveterm)) {
        $sexpositiveterm_sexpositiveterm = array(
            // If we need to define an actual regex, we create a new array here.
            // key is the search pattern, value is the acronym expansion
            // Be certain to include a full-match parenthesis boundary for the replacement!
            array("(Sex Work(ers?)?)" => "http://sexuality.about.com/od/glossary/g/sex_work.htm"),
            "ASFR" => "http://sexuality.about.com/od/glossary/g/asfr.htm",
            "Abstinence" => "http://sexuality.about.com/od/glossary/g/abstinence.htm",
            "Acrotomophilia" => "http://sexuality.about.com/od/glossary/g/Acrotomophilia.htm",
            "Agalmatophilia" => "http://sexuality.about.com/od/glossary/g/agalmatophilia.htm",
            "Agoraphilia" => "http://sexuality.about.com/od/glossary/g/Agoraphilia.htm",
            "Anal Beads" => "http://sexuality.about.com/od/sextoys/a/anal_beads.htm",
            "Anal Dildo" => "http://sexuality.about.com/od/sextoys/a/anal_dildo.htm",
            "Analingus" => "http://sexuality.about.com/od/glossary/g/analingus.htm",
            "Anorgasmia" => "http://sexuality.about.com/od/glossary/g/anorgasmia.htm",
            "Asexual" => "http://sexuality.about.com/od/glossary/g/asexual.htm",
            "Asphyxiophilia" => "http://sexuality.about.com/od/glossary/g/asphyxiophilia.htm",
            "Autofellatio" => "http://sexuality.about.com/od/glossary/g/autofellatio.htm",
            "Avatar" => "http://sexuality.about.com/od/glossary/g/avatar.htm",
            "BDSM" => "http://sexuality.about.com/od/glossary/g/BDSM.htm",
            "Bestiality" => "http://sexuality.about.com/od/glossary/g/bestiality.htm",
            "Bot" => "http://sexuality.about.com/od/glossary/g/bot.htm",
            "Butt Plugs" => "http://sexuality.about.com/od/sextoys/a/butt_plugs.htm",
            "Candaulism" => "http://sexuality.about.com/od/glossary/g/Candaulism.htm",
            "Casual Sex" => "http://sexuality.about.com/od/glossary/g/casual_sex.htm",
            "Certified Sexuality Educator" => "http://sexuality.about.com/od/glossary/g/certified_sexuality_educator.htm",
            "Chlamydia" => "http://sexuality.about.com/od/glossary/g/chlamydia.htm",
            "Coccinelle" => "http://sexuality.about.com/od/glossary/g/Coccinelle.htm",
            "Coitus" => "http://sexuality.about.com/od/glossary/g/coitus.htm",
            "Coprophilia" => "http://sexuality.about.com/od/glossary/g/coprophilia.htm",
            "Cuckold" => "http://sexuality.about.com/od/glossary/g/cuckold.htm",
            "Cuddle Party" => "http://sexuality.about.com/od/glossary/g/cuddleparty.htm",
            "DSM" => "http://sexuality.about.com/od/glossary/g/DSM.htm",
            "Dental Dam" => "http://sexuality.about.com/od/glossary/g/dental_dam.htm",
            "Devotees" => "http://sexuality.about.com/od/glossary/g/devotees.htm",
            "Dildo" => "http://sexuality.about.com/od/glossary/g/dildo.htm",
            "Dual Action Vibrator" => "http://sexuality.about.com/od/glossary/g/dual_action_vib.htm",
            "Dysparuenia" => "http://sexuality.about.com/od/glossary/g/dysparuenia.htm",
            "Edging" => "http://sexuality.about.com/od/glossary/g/edging.htm",
            "Emergent sex" => "http://sexuality.about.com/od/glossary/g/emergent_sex.htm",
            "Erectile Dysfunction" => "http://sexuality.about.com/od/glossary/g/erectiledysfunc.htm",
            "Erotophilia and Erotophobia" => "http://sexuality.about.com/od/glossary/g/erotophilia.htm",
            "Female Orgasmic Disorder" => "http://sexuality.about.com/od/glossary/g/female_orgasmic.htm",
            "Female Sexual Dysfunction" => "http://sexuality.about.com/od/glossary/g/female_sexual_dysfunction.htm",
            "Female genital cosmetic surgery" => "http://sexuality.about.com/od/glossary/g/female_surgery.htm",
            "Fetish" => "http://sexuality.about.com/od/glossary/g/fetish.htm",
            "Frenulum Breve" => "http://sexuality.about.com/od/glossary/g/frenulum_breve.htm",
            "Genetic Determinism" => "http://sexuality.about.com/od/glossary/g/genetic_determ.htm",
            "Genital Herpes" => "http://sexuality.about.com/od/glossary/g/genital_herpes.htm",
            "HSDD" => "http://sexuality.about.com/od/glossary/g/hsdd.htm",
            "Hypersexual Disorder" => "http://sexuality.about.com/od/glossary/g/hypersexual_disorder.htm",
            "Intercourse" => "http://sexuality.about.com/od/glossary/g/intercourse.htm",
            "Kegel Exercises" => "http://sexuality.about.com/od/glossary/g/kegelexercises.htm",
            "Kinsey Scale" => "http://sexuality.about.com/od/glossary/g/Kinsey-Scale.htm",
            "Klismaphilia" => "http://sexuality.about.com/od/glossary/g/klismaphilia.htm",
            "Labiaplasty" => "http://sexuality.about.com/od/glossary/g/labiaplasty.htm",
            "Lichen Sclerosus" => "http://sexuality.about.com/od/glossary/g/Lichensclerosus.htm",
            "Male Orgasmic Disorder" => "http://sexuality.about.com/od/glossary/g/male_orgasmic.htm",
            "Male Strap On" => "http://sexuality.about.com/od/glossary/g/male_strap_on.htm",
            "Male Vibrator" => "http://sexuality.about.com/od/malesextoys/g/Male-Vibrator.htm",
            "Marital Aids" => "http://sexuality.about.com/od/glossary/g/Marital-Aids.htm",
            "Masturbation" => "http://sexuality.about.com/od/glossary/g/masturbation.htm",
            "Non Ejaculatory Orgasm" => "http://sexuality.about.com/od/glossary/g/nonejacorgasm.htm",
            "Non-Monogamy" => "http://sexuality.about.com/od/glossary/g/nonmonogamy.htm",
            "Oral Sex Taste" => "http://sexuality.about.com/od/glossary/g/oral_sex_taste.htm",
            "PC Muscle" => "http://sexuality.about.com/od/glossary/g/pcmuscles.htm",
            "PGAD" => "http://sexuality.about.com/od/glossary/g/pgad.htm",
            "PSAS" => "http://sexuality.about.com/od/glossary/g/psas.htm",
            "Pansexual" => "http://sexuality.about.com/od/glossary/g/pansexual.htm",
            "Paraphilias" => "http://sexuality.about.com/od/glossary/g/paraphilias.htm",
            "Penile Dysmorphophobia" => "http://sexuality.about.com/od/glossary/g/small_penis.htm",
            "Penile Prosthesis" => "http://sexuality.about.com/od/glossary/g/penile_prosthesis.htm",
            "Penis Limiter" => "http://sexuality.about.com/od/glossary/g/penis_limiter.htm",
            "Penis Pumps" => "http://sexuality.about.com/od/glossary/g/penis_pumps.htm",
            "Perineum" => "http://sexuality.about.com/od/glossary/g/perineum.htm",
            "Phimosis" => "http://sexuality.about.com/od/glossary/g/Phimosis.htm",
            "Phthalates" => "http://sexuality.about.com/od/glossary/g/phthalates.htm",
            "Play Piercing" => "http://sexuality.about.com/od/glossary/g/Play-Piercing.htm",
            "Pre-cum" => "http://sexuality.about.com/od/glossary/g/precum.htm",
            "Premature Ejaculation" => "http://sexuality.about.com/od/glossary/g/premature_ejacu.htm",
            "Priapism" => "http://sexuality.about.com/od/glossary/g/priapism_def.htm",
            "Public Display of Affection" => "http://sexuality.about.com/od/glossary/g/public_display_of_affection.htm",
            "Rainbow Parties" => "http://sexuality.about.com/od/glossary/g/rainbowparty.htm",
            "Refractory Period" => "http://sexuality.about.com/od/glossary/g/refratoryperiod.htm",
            "Romantic product salesmen" => "http://sexuality.about.com/od/glossary/g/romanticproduct.htm",
            "Sex Coach" => "http://sexuality.about.com/od/glossary/g/sex-coach.htm",
            "Sex Drive" => "http://sexuality.about.com/od/glossary/g/sex_drive.htm",
            "Sex Educator" => "http://sexuality.about.com/od/glossary/g/sex_educator.htm",
            "Sex Positive" => "http://sexuality.about.com/od/glossary/g/sex_positive.htm",
            "Sex Professional" => "http://sexuality.about.com/od/glossary/g/sex-professional.htm",
            "Sex Researcher" => "http://sexuality.about.com/od/glossary/g/sex-researcher.htm",
            "Sex Tech" => "http://sexuality.about.com/od/glossary/g/sex_tech.htm",
            "Sex Therapist" => "http://sexuality.about.com/od/glossary/g/sex-therapist.htm",
            "Sex Toy" => "http://sexuality.about.com/od/glossary/g/sex_toys.htm",
            "Sexologist" => "http://sexuality.about.com/od/glossary/g/sexologist.htm",
            "Sexology" => "http://sexuality.about.com/od/glossary/g/sexology.htm",
            "Sexual Behavior" => "http://sexuality.about.com/od/glossary/g/sexual_behavior.htm",
            "Sexual Compatibility" => "http://sexuality.about.com/od/glossary/g/sexual_compatibility.htm",
            "Sexual Dysfunction" => "http://sexuality.about.com/od/glossary/g/sexual_dysfunction.htm",
            "Sexual Health" => "http://sexuality.about.com/od/glossary/g/sexual_health.htm",
            "Sexual Identity" => "http://sexuality.about.com/od/glossary/g/sexual_identity.htm",
            "Sexual Intimacy" => "http://sexuality.about.com/od/glossary/g/sexual_intimacy.htm",
            "Sexual Orientation" => "http://sexuality.about.com/od/glossary/g/sexualorientata.htm",
            "Sexual Problem" => "http://sexuality.about.com/od/glossary/g/sexual_problem.htm",
            "Sexual Surrogates" => "http://sexuality.about.com/od/glossary/g/sex_surrogates.htm",
            "Small Penis Syndrome" => "http://sexuality.about.com/od/glossary/g/small_penis_syn.htm",
            "Swinging" => "http://sexuality.about.com/od/glossary/g/Swinging.htm",
            "Teledildonics" => "http://sexuality.about.com/od/glossary/g/teledildonics_.htm",
            "Uncircumcise" => "http://sexuality.about.com/od/glossary/g/Uncircumcise.htm",
            "Vacuum Pumps" => "http://sexuality.about.com/od/glossary/g/vacuum_pumps.htm",
            "Vaginoplasty" => "http://sexuality.about.com/od/glossary/g/vaginoplasty.htm",
            "Vasocongestion" => "http://sexuality.about.com/od/glossary/g/vasocongestion.htm",
            "Vibrator" => "http://sexuality.about.com/od/glossary/g/vibrator.htm",
            "Virtual Sex" => "http://sexuality.about.com/od/glossary/g/virtual_sex.htm",
            "Zoophilia" => "http://sexuality.about.com/od/glossary/g/zoophilia.htm"
        );
    }

    $text = " $text ";
    foreach($sexpositiveterm_sexpositiveterm as $term => $desc) {
        if (is_array($desc)) {
            $regex   = array_keys($desc);
            $search  = $regex[0]; // there should always be just one value here
            $replace = $desc[$search];
            $text = preg_replace("/\b$search\b/", "<a href=\"$replace\" class=\"sspg term\" title=\"Look up '$1'\">$1</a>", $text);
        } else {
            /*    For advanced users, there are several possible regular expressions here....
             *    The safest, "default" one is at the top ...
             *    You (or I) may choose to use one of the others!
             *    Pick whichever you want, and make SURE there is only one that isn't preceded by slashes: //
             */
            // OLD DEFAULT: CONSERVATIVE
            //    $text = preg_replace("|([\s\>])$acronym([\s\<\.,;:\\/\-])|imsU" , "$1<acronym title=\"$description\">$acronym</acronym>$2" , $text);

            // NEW DEFAULT: MORE DARING (case insensitive)
            $text = preg_replace("|([^./?&]\b)$term(\b[^:])|imsU" , "$1<a href=\"$desc\" class=\"sspg term\" title=\"Look up '$term'\">$term</a>$2" , $text);
            $text = preg_replace("|(<[A-Za-z]* [^>]*)<a href=\"$desc\" class=\"sspg term\" title=\"Look up '$term'\">$term</a>([^<]*>)|imsU" , "$1$term$2" , $text);

            // SAME AS ABOVE, but CASE SENSITIVE
            //    $text = preg_replace("|([^./]\b)$acronym(\b[^:])|msU" , "$1<acronym title=\"$description\">$acronym</acronym>$2" , $text);
            //    $text = preg_replace("|(<[A-Za-z]* [^>]*)<acronym title=\"$description\">$acronym</acronym>([^<]*>)|msU" , "$1$acronym$2" , $text);

            // BY REQUEST: if the following preg_replace here is uncommented:
            //             acronyms wrapped in dollar signs will just be unwrapped
            //             So: $AOL$ will become AOL, without the <acronym title="America Online">AOL</acronym>
            $text = preg_replace("|[$]<a href=\"$desc\" class=\"sspg term\" title=\"Look up '$term'\">$term</a>[$]|imsU", "$term", $text);
        }
    }
    return trim( $text );
}

add_filter('the_content', 'sexPositiveGlossaryTerm', 8);
//add_filter('comment_text', 'sexPositiveGlossaryTerm', 8);
?>
