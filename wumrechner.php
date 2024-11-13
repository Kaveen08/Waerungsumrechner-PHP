<?php

function begruessung()
{
    return "Hallo\nWillkommen zum Waehrungsumrechner.\n!!Dieser Waehrungsrechner funktioniert nur zwischen Euro und Franken!!\n";
}
echo begruessung();

function istgueltigerbetrag($betrag)
{
    // Überprüfen, ob der Betrag eine gültige Zahl ist (einschließlich Dezimalzahlen)
    return filter_var($betrag, FILTER_VALIDATE_FLOAT) !== false && $betrag >= 0;
}

function istgueltigeWahl($wahl)
{
    return preg_match('/^[SE]$/', $wahl) === 1;
}

function speichereumrechnung($von, $zu, $betrag, $ergebnis)
{
    $eintrag = date('Y-m-d H:i:s') . " - $betrag $von zu $zu: $ergebnis\n";
    file_put_contents('umrechnungen.txt', $eintrag, FILE_APPEND);
}

do {
    do {
        $waerung = readline("Fuer das Umwandeln in CHF bitte druecken Sie S,\nFuer das Umwandeln in EUR bitte druecken Sie E\n");
        $waerung = strtoupper($waerung);

        if (!istgueltigeWahl($waerung)) {
            echo "Ungueltige Eingabe. Bitte waehlen Sie S oder E.\n";
        }
    } while (!istgueltigeWahl($waerung));

    if ($waerung == "S") {
        do {
            $betrag = readline("Bitte geben Sie Ihren gewuenschten Betrag in Euro ein: ");
            if (!istgueltigerbetrag($betrag)) {
                echo "Bitte geben Sie einen gueltigen Betrag ein.\n";
            }
        } while (!istgueltigerbetrag($betrag));

        $ergebnis = $betrag * 0.94;
        echo sprintf("%.2f Euro sind %.2f Schweizer Franken.\n", $betrag, $ergebnis);
        speichereumrechnung('EUR', 'CHF', $betrag, $ergebnis);
    } else {
        do {
            $betrag = readline("Bitte geben Sie Ihren gewuenschten Betrag in Franken ein: ");
            if (!istgueltigerbetrag($betrag)) {
                echo "Bitte geben Sie einen gueltigen Betrag ein.\n";
            }
        } while (!istgueltigerbetrag($betrag));

        $ergebnis = $betrag * 1.07;
        echo sprintf("%.2f Franken sind %.2f Euro.\n", $betrag, $ergebnis);
        speichereumrechnung('CHF', 'EUR', $betrag, $ergebnis);
    }

    echo "Vielen Dank fuer die Nutzung meines Programms\n";
    $weitermachen = readline("Moechten Sie eine weitere Umrechnung durchfuehren? Druecken Sie J fuer Ja,\noder eine andere Taste fuer Nein: ");
} while (strtolower($weitermachen) === 'j');

echo "Auf Wiedersehen!\n";
