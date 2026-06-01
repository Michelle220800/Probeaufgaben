<?php

/*Gesucht: Prüfen ob eine Lizenz auf mehr als einem Gerät verwendet wird.
Top 10 Lizenzen die gegen diese Regel verstoßen und auf mehreren Geräten installiert sind.
Auf wie vielen verschiedenen Geräten sind die Lizenzen installiert
/*Benötigt: - Logfile das eingelesen wird
            - Seriennummer aus jeder Zeile extrahieren
            - Geräte-ID aus jeder Teile extrahieren
            - Array um die Zugriffe zu zählen
            - Ergebnisse sortieren (Mit arsort)
            - Die ersten 10 Lizenzen mit Anzahl der Geräte ausgeben (array_slice) */