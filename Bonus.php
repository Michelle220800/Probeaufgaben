<?php

/*Gesucht: Anhand der Specs Daten, die verschiedenen Hardwareklassen identifizieren, die im Einsatz sind.
Anzahl der Lizenzen angeben, die auf diesen Hardwarearten aktiv sind
Benötigt: - Logfile das eingelesen wird
          - Specs Daten auslesen und Regel festlegen (Hier cpu auslesen) (Für die Regeln vlt eine Funktion definieren? Oder in if?)
          -> Specs dafür decodieren wie in Aufgabe 2
          - Zeilenweise die specs extrahieren (fopen / fgets)
          - Array für hardwaretyp erstellen
          - Anzahl der Lizenzen erhöhen, die auf den Hardwarearten aktiv sind (Zähler erhöhen)
          - Lizenzen sortieren absteigend (arsort) */

//Array für die Speicherung der Hardwaretypen definieren
$hardwareTyp = [];

//Das Log wieder einlesen
$file = fopen("access.log", "r");
//Codeschnipsel aus Aufgabe 2 nutzen, um specs zu decodieren
while (($line = fgets($file)) !== false) {

    if (preg_match("/specs=([A-Za-z0-9+\/=]+)/", $line, $matches)){

        $encodedSpecs = $matches[1];

        $compressedData = base64_decode($encodedSpecs);
        $jsonString = gzdecode($compressedData);
        $parsedjson = json_decode($jsonString, true);
        //echo $parsedjson["cpu"] . "\n";
        /*Regeln für Cpu festlegen. Dafür Log auslesen und durchschauen was für Typen vorkommen.
        Unsicher in welche Kategorien ich die Hardware filter: Nach Überlegungen nach Google habe ich die Systeme in
        Schwächeres Leistungssystem, Mittleres Leistungssystem, Leistungsstarkes System und sehr starkes Leistungssystem gefiltert.
        Intel(R) Atom(TM) ,  via? -> preisgünstige und enegerisparende Systeme (Laut Google) (Schwächeres System)
        Intel(R) Celeron(R) -> preiswerte Heim- und Bürorechner (Mittleres System)
        Intel(R) Core(TM) i7, i3,i5, quad (Leistungsstarkes System)
        Intel(R) Xeon(R) -> Hochleistungs-cpus für Server (sehr starkes Leistungssystem)
        Intel(R) Pentium(R) -> Für weniger rechenintensive Aufgaben, alltägliche Aufgaben (Mittleres Leistungssystem)
        Amd epyc 7H12 -> Hochleistungs-cpus für Server (sehr starkes Leistungssystem)
        Daraus entwickel ich eine Regel nach der gefiltert werden soll. Diese Regeln versuche ich mithilfe von
        If-Anweisungen dann zu definieren. Davor muss aber das json geprüft werden, ob es gültig ist (also cpu Werte besitzt) oder nicht*/
        //Prüfung dass das json gültig sein muss, bevor das Programm weiter läuft
        if ($parsedjson !== null) {
        /*Ich hole den Wert von den Cpus aus dem Array und falls er fehlt nutze ich einen leeren String
        Mit ?? "" möchte ich den Fall verhindern, dass das Programm crashen könnte oder Warnings gibt, falls cpu nicht existiert in einer Zeile*/
        $cpuData = $parsedjson["cpu"] ?? "";
        $cpu = strtolower($cpuData);
        //Test erfolgreich, Syntax wird nun komplett klein geschrieben
        //echo $cpu . "\n";

            //Ich möchte mit If-Anweisungen die Regeln definieren bei denen die Geräte ausgegeben werden
            //Regel für schwächere Systeme
            if (str_contains($cpu, "atom") || str_contains($cpu, "via")) {
                $type = "Schwächere Leistungssysteme";
            }
            //Regel für mittlere Systeme
            elseif (str_contains($cpu, "celeron") || str_contains($cpu, "pentium")) {
                $type = "Mittlere Leistungssysteme";
            }
            //Regel für Leistungsstarke Systeme
            elseif (str_contains($cpu, "core") || str_contains($cpu, "i3") || str_contains($cpu, "i5") || str_contains($cpu, "i7")) {
                $type = "Leistungsstarke Systeme";
            }
            //Regel für sehr starke Leistungssysteme
            elseif (str_contains($cpu, "amd") || str_contains($cpu,"xeon")) {
                $type = "Sehr starke Leistungssysteme";
            }
            //Für den Fall das es noch andere Systeme gibt
            else {
                $type = "Andere Leistungssysteme";
            }

            /*Nun baue ich noch einen Counter ein für den hardwareTyp den ich am Anfang mit einem Array erstellt habe,
            um die Hardwaretypen zu zählen.*/
            $hardwareTyp[$type] = ($hardwareTyp[$type] ?? 0) + 1;
            //Test erfolgreich, die Systeme werden ausgezählt
            echo $type . " = " . $hardwareTyp[$type] . "\n";
        }
    }
}    

fclose($file);
