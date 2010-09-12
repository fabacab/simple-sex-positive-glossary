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
            "Sex Toy" => "http://sexuality.about.com/od/glossary/g/sex_toys.htm",
            "Sex Positive" => "http://sexuality.about.com/od/glossary/g/sex_positive.htm",
            "ASFR" => "http://sexuality.about.com/od/glossary/g/asfr.htm",
            "Abstinence" => "http://sexuality.about.com/od/glossary/g/abstinence.htm",
            "Acrotomophilia" => "http://sexuality.about.com/od/glossary/g/Acrotomophilia.htm",
            "Agalmatophilia" => "http://sexuality.about.com/od/glossary/g/agalmatophilia.htm"
            // TODO:
//            Agoraphilia
//            Anal Beads
//            Anal Dildo
//            Analingus
//            Anorgasmia
//            Asexual
//            Asphyxiophilia
//            Autofellatio
//            Avatar
//            BDSM
//            Bestiality
//            Bot
//            Butt Plugs
//            Candaulism
//            Casual Sex
//            Certified Sexuality Educator
//            Chlamydia
//            Coccinelle 1931-2006
//            Coitus
//            Coprophilia
//            Cuckold
//            Cuddle Party
//            Dental Dam
//            Devotees
//            Dildo
//            DSM (Diagnostic and Statistical Manual of Mental Disorders)
//            Dual Action Vibrator
//            Dysparuenia
//            Edging
//            Emergent sex
//            Erectile Dysfunction
//            Erotophilia and Erotophobia
//            Female genital cosmetic surgery
//            Female Orgasmic Disorder
//            Female Sexual Dysfunction
//            Fetish
//            Frenulum Breve
//            Fritz Klein 1932-2006
//            Genetic Determinism
//            Genital Herpes
//            Hypersexual Disorder
//            Hypoactive Sexual Desire Disorder (HSDD)
//            Intercourse
//            Kegel Exercises
//            Klismaphilia
//            Labiaplasty
//            Lichen Sclerosus
//            Male Orgasmic Disorder
//            Male Strap On
//            Male Vibrator
//            Masturbation
//            Non Ejaculatory Orgasm
//            Non-Monogamy
//            Oral Sex Taste
//            Pansexual
//            Paraphilias
//            Penile Dysmorphophobia
//            Penile Prosthesis
//            Penis Limiter
//            Penis Pumps
//            Perineum
//            Persistent Genital Arousal Disorder (PGAD)
//            Persistent Sexual Arousal Syndrome (PSAS)
//            Phimosis
//            Phthalates
//            Play Piercing
//            Pre-cum
//            Pre-ejaculatory fluid
//            Premature Ejaculation
//            Priapism
//            Public Display of Affection (PDA)
//            Pubococcygeus (PC) Muscles
//            Rainbow Parties
//            Refractory Period
//            Romantic product salesmen
//            Sex Coach
//            Sex Drive
//            Sex Educator
//            Sex Professional
//            Sex Researcher
//            Sex Tech
//            Sex Therapist
//            Sexologist
//            Sexology
//            Sexual Behavior
//            Sexual Compatibility
//            Sexual Dysfunction
//            Sexual Health
//            Sexual Identity
//            Sexual Intimacy
//            Sexual Orientation
//            Sexual Problem
//            Sexual Surrogates
//            Small Penis Syndrome
//            Swinging
//            Teledildonics
//            Vacuum Pumps
//            Vaginoplasty
//            Vasocongestion
//            Vibrator
//            Virtual Sex
//            Zoophilia
//            Uncircumcise
//            Marital Aids
//            Kinsey Scale
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
