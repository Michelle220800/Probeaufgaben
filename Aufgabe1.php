<?php

//Gesucht: Welche 10 Lizenzen versuchen am häufigsten, auf den Server zuzugreifen. Wie oft versuchen sie auf den Server zuzugreifen
/*Benötigt: - Logfile das eingelesen wird
            - Seriennummer aus jeder Zeile extrahieren (foreach?)
            - Array um die Zugriffe zu zählen
            - Ergebnisse sortieren (Schauen wie man sie absteigend sortiert)
            - Die ersten 10 Einträge mit den höchsten Zugriffen ausgeben */

//Leeres Array erstellen. Für die Speicherung von Seriennummern und Anzahl der Zugriffe
$counter = [];

$lines = file("access.log");

//Schleife um jede Zeile in der Datei auszulesen