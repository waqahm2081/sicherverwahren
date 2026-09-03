<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        if (Faq::count() > 0) {
            return;
        }

        $faqs = [
            [
                'question' => 'Was passiert, wenn ich meine Hardware-Wallet verliere oder sie kaputt geht?',
                'answer'   => '<p>Das ist kein Problem, solange Sie Ihr Backup (die 24 Wörter, auch "Seed" genannt) sicher aufbewahrt haben. Ihre Bitcoin ist nicht auf dem physischen Gerät, sondern auf der Blockchain gespeichert. Die Hardware-Wallet ist nur der Schlüssel dazu. Mit Ihrem Backup können Sie Ihre Bitcoin jederzeit auf einer neuen Wallet wiederherstellen. Wir zeigen Ihnen im Service genau, wie das funktioniert und wo Sie Ihr Backup am besten lagern.</p>',
            ],
            [
                'question' => 'Kann ich auch andere Kryptowährungen wie Ethereum mit Ihnen sichern?',
                'answer'   => '<p>Nein. Wir konzentrieren uns ausschließlich auf Bitcoin. Wir sind überzeugte Bitcoiner und unterstützen aus Überzeugung und für maximale Sicherheit keine anderen Kryptowährungen. Unsere Expertise, unsere Prozesse und die von uns empfohlene Hardware (BitBox02 Bitcoin-only) sind spezifisch auf Bitcoin optimiert.</p>',
            ],
            [
                'question' => 'Wie lange dauert ein typischer Einrichtungstermin?',
                'answer'   => '<p>Die Dauer hängt vom gewählten Paket ab.<br><strong>Private Starter:</strong> Ca. 1,5 - 2 Stunden<br><strong>Private Secure / Business Essential:</strong> Ca. 3 - 4 Stunden<br><strong>Business Professional:</strong> Ca. 4 - 5 Stunden<br><strong>Business Enterprise:</strong> Ein Tag oder mehrere Termine</p>',
            ],
            [
                'question' => 'Ist die Hardware-Wallet im Paketpreis inbegriffen?',
                'answer'   => '<p>Ja, absolut. Der Preis ist all-inclusive. Sie bezahlen einmalig für das Paket und erhalten dafür die Hardware, die persönliche Einrichtung bei Ihnen vor Ort, die Schulung und die Dokumentation. Es gibt keine versteckten Kosten.</p>',
            ],
            [
                'question' => 'Warum sollte ich Sie beauftragen und es nicht selbst machen?',
                'answer'   => '<p>Weil es um Ihr wertvolles Vermögen geht. Der Teufel steckt im Detail: Ein Tippfehler beim Aufschreiben des Seeds, ein unsicheres Backup-Medium oder ein falsch konfiguriertes Multi-Signature-Setup kann zu einem unwiederbringlichen Verlust führen. Wir bringen jahrelange Erfahrung und wissen, worauf es ankommt. Wir sorgen dafür, dass es von Anfang an richtig und sicher gemacht wird, damit Sie beruhigt schlafen können.</p>',
            ],
            [
                'question' => 'Stellen Quantencomputer ein Risiko für Bitcoin dar – und wann?',
                'answer'   => '<p><strong>Wer ist Adam Back?</strong><br>Adam Back ist ein britischer Kryptograf und CEO von Blockstream. Er ist eine der angesehensten Persönlichkeiten in der Bitcoin-Welt. Bereits 1997 erfand er Hashcash, das später als Grundlage für Bitcoins Mining-Algorithmus diente. Im Original-Bitcoin-Whitepaper von Satoshi Nakamoto wird Adam Back namentlich zitiert. Seine Einschätzung zur Quantencomputer-Bedrohung hat daher besonderes Gewicht.</p><p><strong>Seine Aussage:</strong><br>Quantencomputer sind für Bitcoin "ridiculously early". Eine echte Bedrohung sieht er frühestens in 20–40 Jahren. Zudem betont er zwei entscheidende Punkte:<br>Erstens: Quantencomputer werden zuerst leichtere Ziele angreifen – Banken, Militär, staatliche Kommunikation. Deren RSA- und Diffie-Hellman-Verschlüsselung ist weit verwundbarer als Bitcoins ECDSA. Diese Systeme sind das "niedrig hängende Obst".<br>Zweitens: Selbst wenn Quantencomputer leistungsfähig genug sind, ist Mining ökonomisch attraktiver als ein Angriff. Die akademische Forschung zeigt: Ein Quanten-Miner, der 16 Minuten Grover-Iterationen fährt und dann misst, kann effizienter minen als klassische Rechner – mit besseren Energiekosten pro Block. Warum das Netzwerk angreifen, wenn man es profitabler nutzen kann?</p><p><strong>Fazit:</strong><br>Kein Grund zur Sorge. Das Fenster für ein geordnetes Upgrade ist groß, und die Ökonomie spricht gegen einen Angriff.</p>',
            ],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::create([
                'question'   => $faq['question'],
                'answer'     => $faq['answer'],
                'sort_order' => $i,
                'is_active'  => true,
            ]);
        }
    }
}
