<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Seed frequently asked questions.
     */
    public function run(): void
    {
        foreach ($this->items() as $index => $item) {
            $faq = Faq::query()->updateOrCreate(
                ['key' => $item['key']],
                [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );

            foreach ($item['translations'] as $locale => $translation) {
                $faq->translations()->updateOrCreate(
                    ['locale' => $locale],
                    $translation,
                );
            }
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function items(): array
    {
        return [
            [
                'key' => 'which-devices',
                'translations' => [
                    'de' => [
                        'question' => 'Welche Geräte reparieren Sie?',
                        'answer' => 'Wir prüfen und reparieren unter anderem Smartphones, Tablets, Computer und weitere Elektronik, sofern Zustand, Ersatzteile und wirtschaftlicher Aufwand das zulassen. Eine verbindliche Aussage ist erst nach Diagnose möglich. Wenn eine Reparatur nicht sinnvoll ist, teilen wir das offen mit.',
                    ],
                    'en' => [
                        'question' => 'Which devices do you repair?',
                        'answer' => 'We inspect and repair smartphones, tablets, computers and other electronics where condition, spare parts and cost make a repair reasonable. A binding statement is only possible after diagnosis. If a repair is not advisable, we say so openly.',
                    ],
                ],
            ],
            [
                'key' => 'on-site',
                'translations' => [
                    'de' => [
                        'question' => 'Bieten Sie Vor-Ort-Service an?',
                        'answer' => 'Ja, Vor-Ort-Termine sind nach Absprache möglich – etwa wenn Hardware geprüft werden muss, kein Fernzugriff besteht oder ein gemeinsamer Termin vor Ort schneller zum Ziel führt. Termin, Anfahrt und Leistungsumfang vereinbaren wir individuell. Remote-Support bleibt eine Alternative, wenn er fachlich ausreicht.',
                    ],
                    'en' => [
                        'question' => 'Do you offer on-site service?',
                        'answer' => 'Yes, on-site appointments are possible by arrangement — for example when hardware needs inspection, remote access is not available, or a joint visit is faster. Date, travel and scope are agreed individually. Remote support remains an option when it is technically sufficient.',
                    ],
                ],
            ],
            [
                'key' => 'business-customers',
                'translations' => [
                    'de' => [
                        'question' => 'Arbeiten Sie mit Unternehmen?',
                        'answer' => 'Ja. Wir arbeiten mit kleinen und mittleren Betrieben, Technologieunternehmen, Werkstätten, Laboren und anderen gewerblichen Kunden. Möglich sind einmalige Einsätze, Reparaturen, Support, Wartung im vereinbarten Rahmen oder projektbezogene Unterstützung. Der genaue Umfang wird vorab festgehalten.',
                    ],
                    'en' => [
                        'question' => 'Do you work with businesses?',
                        'answer' => 'Yes. We work with small and medium-sized businesses, technology companies, workshops, laboratories and other commercial customers. That can mean one-off assignments, repairs, support, maintenance within an agreed scope, or project-based assistance. The exact scope is recorded in advance.',
                    ],
                ],
            ],
            [
                'key' => 'it-support',
                'translations' => [
                    'de' => [
                        'question' => 'Bieten Sie IT-Support an?',
                        'answer' => 'Ja. Zum technischen Support gehören Störungsaufnahme, Systemanalyse, Remote-Hilfe, Installation und Konfiguration sowie Wartung nach Vereinbarung. Der Support richtet sich an Privat- und Geschäftskunden. Ein pauschaler 24/7-Notdienst ist nicht automatisch enthalten.',
                    ],
                    'en' => [
                        'question' => 'Do you provide IT support?',
                        'answer' => 'Yes. Technical support includes incident intake, system analysis, remote assistance, installation and configuration, and maintenance by agreement. Support is available to private and business customers. A blanket 24/7 emergency service is not included by default.',
                    ],
                ],
            ],
            [
                'key' => 'custom-software',
                'translations' => [
                    'de' => [
                        'question' => 'Können individuelle Softwarelösungen entwickelt werden?',
                        'answer' => 'Ja, sofern die Aufgabe zu uns passt. Wir entwickeln Desktop-Anwendungen, Smartphone-Apps, Buchhaltungs- und Rechnungssysteme, Webanwendungen, Schnittstellen und individuelle Software. Außerdem beheben wir Fehler, aktualisieren bestehende Programme, ergänzen Funktionen und übernehmen Datenverwaltung. Zuerst klären wir Ziel, Schnittstellen und ob eine Individualentwicklung der richtige Weg ist. Lieferumfang und Zeitrahmen werden vereinbart, nicht pauschal zugesagt.',
                    ],
                    'en' => [
                        'question' => 'Can you develop custom software solutions?',
                        'answer' => 'Yes, where the task is a good fit. We develop desktop applications, smartphone apps, accounting and invoicing systems, web applications, interfaces and custom software. We also fix faults, update existing programs, add features and handle data management. We first clarify the goal, interfaces and whether custom development is actually the right path. Delivery scope and timeline are agreed, not promised as a generic package.',
                    ],
                ],
            ],
            [
                'key' => 'how-to-request',
                'translations' => [
                    'de' => [
                        'question' => 'Wie kann ich einen Service anfragen?',
                        'answer' => 'Nutzen Sie das Kontaktformular und beschreiben Sie möglichst konkret, worum es geht: Gerät oder System, beobachtetes Verhalten, bisherige Schritte und ob ein Vor-Ort-Termin nötig erscheint. Sie erhalten eine Rückmeldung, sobald die Anfrage gesichtet wurde. Ein Formularversand ist noch keine Auftragsannahme.',
                    ],
                    'en' => [
                        'question' => 'How can I request a service?',
                        'answer' => 'Use the contact form and describe the matter as specifically as you can: device or system, observed behaviour, steps already taken, and whether an on-site visit seems necessary. You will receive a response once the enquiry has been reviewed. Submitting the form is not yet an acceptance of an order.',
                    ],
                ],
            ],
            [
                'key' => 'repair-process',
                'translations' => [
                    'de' => [
                        'question' => 'Wie läuft eine Reparatur ab?',
                        'answer' => 'Nach Ihrer Anfrage folgt die Diagnose. Anschließend besprechen wir das mögliche Vorgehen und die voraussichtlichen Kosten, soweit sie sich zu diesem Zeitpunkt benennen lassen. Die Reparatur erfolgt erst nach Ihrer Freigabe. Zum Abschluss prüfen wir die betroffenen Funktionen und übergeben das Gerät bzw. das Ergebnis.',
                    ],
                    'en' => [
                        'question' => 'How does a repair proceed?',
                        'answer' => 'Your enquiry is followed by diagnosis. We then discuss the possible approach and expected costs where they can be stated at that point. Repair work starts only after your approval. At the end we test the affected functions and hand over the device or the result.',
                    ],
                ],
            ],
            [
                'key' => 'quote',
                'translations' => [
                    'de' => [
                        'question' => 'Wie erhalte ich ein Angebot?',
                        'answer' => 'Ein belastbares Angebot setzt in der Regel Informationen zum konkreten Fall voraus – oft eine Diagnose. Nach Sichtung Ihrer Anfrage nennen wir entweder direkt einen Rahmen oder schlagen den nächsten Prüfungsschritt vor. Pauschalpreise ohne Kenntnis des Geräts oder Systems sind meist nicht seriös. Schriftliche Angebote gelten im jeweils genannten Zeitraum.',
                    ],
                    'en' => [
                        'question' => 'How do I receive a quote?',
                        'answer' => 'A reliable quote usually requires information about the specific case — often a diagnosis. After reviewing your enquiry we either outline a range or propose the next inspection step. Flat prices without knowledge of the device or system are rarely serious. Written quotes apply for the period stated.',
                    ],
                ],
            ],
        ];
    }
}
