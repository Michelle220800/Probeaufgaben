<?php

//Gesucht: Welche 10 Lizenzen versuchen am häufigsten, auf den Server zuzugreifen. Wie oft versuchen sie auf den Server zuzugreifen
/*Benötigt: - Logfile das eingelesen wird
            - Seriennummer aus jeder Zeile extrahieren (foreach?)
            - Array um die Zugriffe zu zählen
            - Ergebnisse sortieren (Schauen wie man sie absteigend sortiert)
            - Die ersten 10 Einträge mit den höchsten Zugriffen ausgeben */

//Leeres Array erstellen. Für die Speicherung von Seriennummern und Anzahl der Zugriffe
$counter = [];

/*Mit $lines = file wurde die gesamte Datei auf einmal geladen.
Da die Datei zu groß ist verwende ich fopen wodurch die Datei nur geöffnet wird.*/
$file = fopen("access.log", "r");

/*foreach ersetzt durch eine while Schleife, um die Zeilen solange auszulesen, bis die Datei das Ende erreicht.
fgets wird hier nun genutzt um die Zeile auszulesen.*/
while (($line = fgets($file)) !== false) {
        
/*Format festlegen, welches die Seriennummer hat.
preg_match sucht mit einem Muster nach der Seriennummer*/ 
    if (preg_match("/serial=([A-Z0-9]+)/", $line, $matches)) {

//gefundene Seriennummer wird in einer Variablen gespeichert
        $serial = $matches[1];

//Wenn der Werrt für Seriennummer existiert, nimm ihn, wenn nicht setze 0. Zähler erhöht sich um 1
        $counter[$serial] = 
            ($counter[$serial] ?? 0) + 1;
    }
}

fclose($file);

//Sortiert das Array absteigend
arsort($counter);

//Definiere das er nur die ersten 10 Elemente nimmt.
$top10 = array_slice($counter,0,10, true);

echo "Top 10 Lizenzen-Seriennummern\n";
echo "---------------------------\n";

//Schleife über die Top 10, um die Zugriffe auszulesen
foreach ($top10 as $serial => $count) {
    
    //Ausgabe pro Eintrag
    echo $serial . " : Zugriff auf den Server " . $count . " Mal." . "\n";
}

