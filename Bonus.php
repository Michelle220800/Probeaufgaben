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
        Intel(R) Atom(TM) ,  via?
        Intel(R) Celeron(R)
        Intel(R) Core(TM) i7, i3,i5, quad
        Intel(R) Xeon(R)
        Intel(R) Pentium(R)
        Amd
        Daraus entwickel ich eine Regel nach der gefiltert werden soll. Diese Regeln versuche ich mithilfe von
        If-Anweisungen dann zu definieren. Davor muss aber das json geprüft werden, ob es gültig ist (also cpu Werte besitzt) oder nicht*/
        //Prüfung dass das json gültig sein muss, bevor das Programm weiter läuft
        if ($parsedjson !== null) {
        /*Ich hole den Wert von den Cpus aus dem Array und falls er fehlt nutze ich einen leeren String
        Mit ?? "" möchte ich den Fall verhindern, dass das Programm crashen könnte oder Warnings gibt, falls cpu nicht existiert in einer Zeile*/
        $cpuData = $parsedjson["cpu"] ?? "";
        $cpu = strtolower($cpuData);
        //Test erfolgreich, Syntax wird nun komplett klein geschrieben
        echo $cpu . "\n";
        }
    }
}

fclose($file);
