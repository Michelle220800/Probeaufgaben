<?php

/*Gesucht: Prüfen ob eine Lizenz auf mehr als einem Gerät verwendet wird.
Top 10 Lizenzen die gegen diese Regel verstoßen und auf mehreren Geräten installiert sind.
Auf wie vielen verschiedenen Geräten sind die Lizenzen installiert
/*Benötigt: - Logfile das eingelesen wird
            - Seriennummer aus jeder Zeile extrahieren
            - Geräte-ID aus jeder Zeile extrahieren -> Specs müssen dekodiert werden
            - Array um die Zugriffe zu zählen
            - Ergebnisse sortieren (Mit arsort)
            - Die ersten 10 Lizenzen mit Anzahl der Geräte ausgeben (array_slice) */

//Array für die Speicherung der verschiedenen Geräte wird angelegt.
$devices = [];

//Code wird übernommen aus Aufgabe 1, um die Datei zu öffnen und zu lesen
$file = fopen("access.log", "r");

while (($line = fgets($file)) !== false) {
/*Aus den gegebenen Infos weiß ich, dass es eine Mac-Adresse sein muss, die in den specs ist.
Falls in einer Zeile Daten fehlhaft sind, setze ich beide Werte auf null. Andererseits könnte eine Mac-Adresse aus der neuen Zeile mit der
Seriennummer der Zeile davor verknüpft werden.*/
    $serial = null;
    $mac = null;
//Seriennummern werden extrahiert
    if (preg_match("/serial=([A-Z0-9]+)/", $line, $matches)) {

        $serial = $matches[1];
/* echo "Seriennummer gefunden: $serial\n";
        break; */
    }

//Die Specs müssen extrahiert werden und dekodiert werden. Hier habe ich gegoogelt wie man json dekodieren kann.
    if (preg_match("/specs=([A-Za-z0-9+\/=]+)/", $line, $matches)){
/*Nach einigen Versuchen json zu decoden, hab ich mir in der Aufgabenstellung die specs nochmal angeschaut
und festgestellt das bei den specs in der letzten Reihe steht, dass es als gzip komprimiert wurde und anschließend
als Base64 kodiert wurde. Heißt ich muss erst Base64 decoden und dann gzip decoden, um die JSON zu decoden. */
        //Encodierte Daten aus dem Log holen
        $encodedSpecs = $matches[1];
        //Base64 decoden
        $compressedData = base64_decode($encodedSpecs);
        //Testen ob das Decoding von base64 funktioniert -> Funktioniert, also als nächstes Gzip decoden
        echo $compressedData;
    }
}