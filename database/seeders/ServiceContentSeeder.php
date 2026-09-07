<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceContentSeeder extends Seeder
{
    /**
     * Seed service categories and services with German and English content.
     */
    public function run(): void
    {
        foreach ($this->catalog() as $index => $categoryData) {
            $services = $categoryData['services'];
            unset($categoryData['services']);

            $translations = $categoryData['translations'];
            unset($categoryData['translations']);

            $category = ServiceCategory::query()->updateOrCreate(
                ['key' => $categoryData['key']],
                [
                    'icon' => $categoryData['icon'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );

            foreach ($translations as $locale => $translation) {
                $category->translations()->updateOrCreate(
                    ['locale' => $locale],
                    $translation,
                );
            }

            foreach ($services as $serviceIndex => $serviceData) {
                $serviceTranslations = $serviceData['translations'];
                unset($serviceData['translations']);

                $service = Service::query()->updateOrCreate(
                    ['key' => $serviceData['key']],
                    [
                        'service_category_id' => $category->id,
                        'icon' => $serviceData['icon'],
                        'sort_order' => $serviceIndex + 1,
                        'is_active' => true,
                    ],
                );

                foreach ($serviceTranslations as $locale => $translation) {
                    $service->translations()->updateOrCreate(
                        ['locale' => $locale],
                        $translation,
                    );
                }
            }
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function catalog(): array
    {
        return [
            [
                'key' => 'software-it',
                'icon' => 'code',
                'translations' => [
                    'de' => [
                        'name' => 'Software & IT-Dienstleistungen',
                        'slug' => 'software-it',
                        'excerpt' => 'Desktop- und Mobile-Apps, Buchhaltungs- und Rechnungssysteme, individuelle Entwicklung, Daten sowie Wartung bestehender Software.',
                        'description' => 'Tay Reparaturservice plant, entwickelt und betreut digitale Systeme: Desktop-Anwendungen, Smartphone-Apps, Buchhaltungs- und Rechnungssysteme, individuelle Software aller Art, Datenverwaltung sowie Fehlerbehebung, Updates und neue Funktionen. Wo es der Aufgabe dient, setzen wir aktuelle Werkzeuge einschließlich KI-gestützter Verfahren ein. Umfang und Schnittstellen werden vor der Umsetzung vereinbart.',
                        'seo_title' => 'Software & IT-Dienstleistungen | Tay Reparaturservice',
                        'seo_description' => 'Desktop-Apps, Mobile-Apps, Buchhaltung und Rechnungen, individuelle Software, Daten und Softwarewartung – nach Absprache.',
                    ],
                    'en' => [
                        'name' => 'Software & IT Services',
                        'slug' => 'software-it',
                        'excerpt' => 'Desktop and mobile apps, accounting and invoicing systems, custom development, data work, and maintenance of existing software.',
                        'description' => 'Tay Reparaturservice plans, builds and maintains digital systems: desktop applications, smartphone apps, accounting and invoicing systems, custom software of many kinds, data management, plus fixes, updates and new features. Where it helps the task, we use current tools including AI-assisted methods. Scope and interfaces are agreed before implementation.',
                        'seo_title' => 'Software & IT Services | Tay Reparaturservice',
                        'seo_description' => 'Desktop apps, mobile apps, accounting and invoicing, custom software, data and software maintenance — by agreement.',
                    ],
                ],
                'services' => [
                    $this->service('software-development', 'code', [
                        'de' => [
                            'name' => 'Softwareentwicklung',
                            'slug' => 'softwareentwicklung',
                            'excerpt' => 'Individuelle Software für interne Abläufe, Fachanwendungen und technische Prozesse.',
                            'description' => 'Wir entwickeln Software, die sich an Ihre bestehenden Abläufe anpasst – nicht umgekehrt. Das kann ein internes Werkzeug, eine Fachanwendung oder eine Erweiterung vorhandener Systeme sein. Zu Beginn klären wir Ziel, Rahmen und Schnittstellen. Anschließend setzen wir die Lösung schrittweise um und stimmen Zwischenergebnisse mit Ihnen ab. Der Leistungsumfang wird jeweils vereinbart; wir versprechen keine Standardplattform und keine pauschalen Lieferzeiten.',
                            'features' => [
                                'Anforderungsanalyse und technische Konzeption',
                                'Umsetzung nach vereinbartem Umfang',
                                'Abstimmung mit bestehenden Systemen',
                                'Dokumentation der wesentlichen Funktionen',
                            ],
                            'seo_title' => 'Softwareentwicklung | Tay Reparaturservice',
                            'seo_description' => 'Individuelle Softwareentwicklung für Unternehmen: Analyse, Umsetzung und Pflege nach Bedarf und Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Software Development',
                            'slug' => 'software-development',
                            'excerpt' => 'Custom software for internal workflows, specialist applications and technical processes.',
                            'description' => 'We develop software that fits your existing workflows rather than forcing a generic process onto your team. That may be an internal tool, a specialist application or an extension of systems you already use. We start by clarifying goals, scope and interfaces, then implement the solution in stages and review progress with you. Scope is always agreed in advance; we do not promise a standard platform or blanket delivery times.',
                            'features' => [
                                'Requirements analysis and technical concept',
                                'Implementation within an agreed scope',
                                'Alignment with existing systems',
                                'Documentation of essential functions',
                            ],
                            'seo_title' => 'Software Development | Tay Reparaturservice',
                            'seo_description' => 'Custom software development for businesses: analysis, implementation and maintenance based on agreed requirements.',
                        ],
                    ]),
                    $this->service('web-development', 'globe', [
                        'de' => [
                            'name' => 'Webentwicklung',
                            'slug' => 'webentwicklung',
                            'excerpt' => 'Professionelle Websites und webbasierte Anwendungen mit klarer Struktur und guter Wartbarkeit.',
                            'description' => 'Wir realisieren Websites und webbasierte Anwendungen für Unternehmen, die eine seriöse digitale Präsenz oder interne Webwerkzeuge benötigen. Der Fokus liegt auf klarer Informationsarchitektur, Barrierearmut, Performance und einer technischen Basis, die sich später erweitern lässt. Inhalte, Funktionen und Designrichtung werden vor der Umsetzung abgestimmt. Hosting, Domain und redaktionelle Betreuung können Teil der Vereinbarung sein, sind aber nicht automatisch enthalten.',
                            'features' => [
                                'Unternehmenswebsites und Webanwendungen',
                                'Mehrsprachige Auftritte',
                                'Formulare und Anfragesysteme',
                                'Technische Pflege nach Absprache',
                            ],
                            'seo_title' => 'Webentwicklung | Tay Reparaturservice',
                            'seo_description' => 'Webentwicklung für Unternehmen: Websites und webbasierte Anwendungen mit Fokus auf Klarheit, Performance und Wartbarkeit.',
                        ],
                        'en' => [
                            'name' => 'Web Development',
                            'slug' => 'web-development',
                            'excerpt' => 'Professional websites and web applications with a clear structure and maintainable technical foundation.',
                            'description' => 'We build websites and web applications for organisations that need a credible digital presence or internal web tools. The focus is on clear information architecture, accessibility, performance and a technical base that can grow later. Content, features and design direction are agreed before implementation. Hosting, domains and editorial support can form part of an agreement but are not included by default.',
                            'features' => [
                                'Company websites and web applications',
                                'Multilingual sites',
                                'Forms and enquiry systems',
                                'Technical maintenance by agreement',
                            ],
                            'seo_title' => 'Web Development | Tay Reparaturservice',
                            'seo_description' => 'Web development for businesses: websites and web applications focused on clarity, performance and maintainability.',
                        ],
                    ]),
                    $this->service('custom-software', 'layers', [
                        'de' => [
                            'name' => 'Individuelle Softwarelösungen',
                            'slug' => 'individuelle-softwareloesungen',
                            'excerpt' => 'Maßgeschneiderte digitale Lösungen aller Art, wenn Standardsoftware nicht ausreicht.',
                            'description' => 'Nicht jedes Problem lässt sich mit einer fertigen Software sinnvoll lösen. Wenn Ihre Abläufe, Schnittstellen oder technischen Randbedingungen zu speziell sind, entwickeln wir eine Lösung, die genau diesen Rahmen berücksichtigt – Desktop, Mobil, Web, interne Werkzeuge oder eine Kombination. Wir klären zunächst, ob eine individuelle Entwicklung überhaupt der richtige Weg ist – manchmal reicht eine Anpassung bestehender Werkzeuge. Die Zusammenarbeit erfolgt projektbezogen und nach schriftlicher Abstimmung des Umfangs.',
                            'features' => [
                                'Prüfung, ob Individualentwicklung sinnvoll ist',
                                'Lösungskonzept auf Basis Ihrer Abläufe',
                                'Iterative Umsetzung mit Rücksprache',
                                'Übergabe und optionale Weiterbetreuung',
                            ],
                            'seo_title' => 'Individuelle Softwarelösungen | Tay Reparaturservice',
                            'seo_description' => 'Maßgeschneiderte Software aller Art, wenn Standardprodukte nicht passen – konzipiert und umgesetzt nach Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Custom Software Solutions',
                            'slug' => 'custom-software-solutions',
                            'excerpt' => 'Tailored digital solutions of many kinds when off-the-shelf software is not a good fit.',
                            'description' => 'Not every problem is best solved with a ready-made product. When your workflows, interfaces or technical constraints are too specific, we design a solution that respects that context — desktop, mobile, web, internal tools or a mix. We first consider whether custom development is actually the right path — sometimes adapting existing tools is enough. Work is project-based and proceeds after the scope has been agreed in writing.',
                            'features' => [
                                'Assessment of whether custom development is appropriate',
                                'Solution design based on your workflows',
                                'Iterative implementation with regular review',
                                'Handover and optional ongoing support',
                            ],
                            'seo_title' => 'Custom Software Solutions | Tay Reparaturservice',
                            'seo_description' => 'Custom software of many kinds when standard products do not fit — designed and delivered by agreement.',
                        ],
                    ]),
                    $this->service('desktop-applications', 'monitor', [
                        'de' => [
                            'name' => 'Desktop-Anwendungen',
                            'slug' => 'desktop-anwendungen',
                            'excerpt' => 'Programme für Windows und andere Arbeitsplatzrechner – intern, fachspezifisch oder an vorhandene Abläufe angebunden.',
                            'description' => 'Wir entwickeln Desktop-Anwendungen, wenn ein Arbeitsplatzprogramm die passende Form ist: interne Werkzeuge, fachliche Clients oder Programme, die lokal mit Geräten, Dateien oder bestehenden Systemen arbeiten. Zu Beginn klären wir Betriebssystem, Verteilung, Schnittstellen und was offline möglich sein muss. Die Umsetzung erfolgt im vereinbarten Umfang; eine pauschale Unterstützung aller Plattformen ist nicht automatisch enthalten.',
                            'features' => [
                                'Bedarfs- und Umfeldklärung am Arbeitsplatz',
                                'Umsetzung als Desktop-Programm nach Vereinbarung',
                                'Anbindung an vorhandene Daten und Systeme',
                                'Übergabe, Installation und optionale Pflege',
                            ],
                            'seo_title' => 'Desktop-Anwendungen | Tay Reparaturservice',
                            'seo_description' => 'Entwicklung von Desktop-Anwendungen für Unternehmen: interne Programme, fachliche Clients und Anbindung an bestehende Abläufe.',
                        ],
                        'en' => [
                            'name' => 'Desktop Applications',
                            'slug' => 'desktop-applications',
                            'excerpt' => 'Programs for Windows and other workstations — internal, specialist, or connected to existing workflows.',
                            'description' => 'We build desktop applications when a workstation program is the right shape: internal tools, specialist clients, or software that works locally with devices, files or existing systems. We start by clarifying the operating system, distribution, interfaces and what must work offline. Implementation stays within the agreed scope; support for every platform is not included by default.',
                            'features' => [
                                'Clarifying needs and the workstation environment',
                                'Implementation as a desktop program by agreement',
                                'Connection to existing data and systems',
                                'Handover, installation and optional upkeep',
                            ],
                            'seo_title' => 'Desktop Applications | Tay Reparaturservice',
                            'seo_description' => 'Desktop application development for businesses: internal programs, specialist clients and connections to existing workflows.',
                        ],
                    ]),
                    $this->service('mobile-applications', 'smartphone', [
                        'de' => [
                            'name' => 'Smartphone- und Mobile-Apps',
                            'slug' => 'smartphone-apps',
                            'excerpt' => 'Anwendungen für Smartphones und Tablets – intern, für Kunden oder als Ergänzung zu bestehenden Systemen.',
                            'description' => 'Wir entwickeln Apps für Smartphones und Tablets, wenn mobile Nutzung zum Auftrag gehört: Erfassung vor Ort, interne Abläufe oder ein abgegrenzter Kundenzugang. Plattform, Funktionen, Anmeldung und Anbindung an Server oder bestehende Software werden vor der Umsetzung festgelegt. Store-Veröffentlichung, Push-Dienste und Geräteflotten können Teil der Vereinbarung sein, sind aber nicht automatisch enthalten.',
                            'features' => [
                                'Klärung von Plattform, Nutzung und Umfang',
                                'Umsetzung der vereinbarten App-Funktionen',
                                'Anbindung an vorhandene Systeme und Daten',
                                'Übergabe und optionale Weiterentwicklung',
                            ],
                            'seo_title' => 'Smartphone-Apps | Tay Reparaturservice',
                            'seo_description' => 'Entwicklung von Smartphone- und Tablet-Apps: interne Abläufe, Erfassung vor Ort und Anbindung an bestehende Systeme.',
                        ],
                        'en' => [
                            'name' => 'Smartphone and Mobile Apps',
                            'slug' => 'mobile-apps',
                            'excerpt' => 'Applications for smartphones and tablets — internal, for customers, or as a complement to existing systems.',
                            'description' => 'We build apps for smartphones and tablets when mobile use is part of the assignment: on-site capture, internal workflows or a bounded customer access. Platform, features, sign-in and connections to servers or existing software are fixed before implementation. Store publication, push services and device fleets can be part of an agreement but are not included by default.',
                            'features' => [
                                'Clarifying platform, use and scope',
                                'Implementation of the agreed app features',
                                'Connection to existing systems and data',
                                'Handover and optional further development',
                            ],
                            'seo_title' => 'Mobile Apps | Tay Reparaturservice',
                            'seo_description' => 'Smartphone and tablet app development: internal workflows, on-site capture and connections to existing systems.',
                        ],
                    ]),
                    $this->service('accounting-systems', 'clipboard', [
                        'de' => [
                            'name' => 'Buchhaltungs- und Rechnungssysteme',
                            'slug' => 'buchhaltung-rechnungen',
                            'excerpt' => 'Software für Rechnungen, Belege und buchhalterische Abläufe – abgestimmt auf Ihren Betrieb, nicht als Fertigprodukt von der Stange.',
                            'description' => 'Wir entwickeln oder erweitern Systeme für Rechnungsstellung, Belegerfassung und verwandte buchhalterische Abläufe, wenn Standardsoftware Ihre Organisation nicht abbildet. Dazu können Nummernkreise, Steuersätze, Export in Ihre Buchhaltung, Rechte und nachvollziehbare Belegflüsse gehören. Steuerliche und rechtliche Verantwortung bleibt beim Auftraggeber und dessen Steuerberatung. Wir setzen den vereinbarten technischen Umfang um, ersetzen aber keine Buchführung und keine Steuerberatung.',
                            'features' => [
                                'Klärung der Beleg- und Rechnungsabläufe',
                                'Umsetzung vereinbarter Erfassungs- und Belegfunktionen',
                                'Export oder Anbindung an vorhandene Buchhaltung',
                                'Dokumentation der wesentlichen Funktionen',
                            ],
                            'seo_title' => 'Buchhaltungs- und Rechnungssysteme | Tay Reparaturservice',
                            'seo_description' => 'Entwicklung von Rechnungs- und Buchhaltungssoftware im vereinbarten Umfang – ohne Ersatz für Steuerberatung.',
                        ],
                        'en' => [
                            'name' => 'Accounting and Invoicing Systems',
                            'slug' => 'accounting-invoicing-systems',
                            'excerpt' => 'Software for invoices, records and bookkeeping workflows — aligned with your organisation, not a generic off-the-shelf product.',
                            'description' => 'We build or extend systems for invoicing, record capture and related bookkeeping workflows when standard software does not match your organisation. That can include number ranges, tax rates, export into your accounts, permissions and traceable document flows. Tax and legal responsibility stays with the client and their tax adviser. We implement the agreed technical scope; we do not replace bookkeeping or tax advice.',
                            'features' => [
                                'Clarifying invoice and record workflows',
                                'Implementation of agreed capture and document features',
                                'Export or connection to existing accounts',
                                'Documentation of essential functions',
                            ],
                            'seo_title' => 'Accounting and Invoicing Systems | Tay Reparaturservice',
                            'seo_description' => 'Development of invoicing and accounting software within an agreed scope — not a substitute for tax advice.',
                        ],
                    ]),
                    $this->service('api-development', 'share', [
                        'de' => [
                            'name' => 'API-Entwicklung',
                            'slug' => 'api-entwicklung',
                            'excerpt' => 'Schnittstellen, mit denen Systeme zuverlässig Daten austauschen können.',
                            'description' => 'Viele technische Probleme entstehen, weil Systeme nicht miteinander sprechen. Wir entwickeln und pflegen APIs, damit Anwendungen, Geräte oder interne Dienste kontrolliert Daten austauschen können. Dazu gehören Abstimmung der Datenmodelle, Authentifizierung nach vereinbartem Verfahren, Dokumentation der Endpunkte und Tests der wesentlichen Pfade. Sicherheitsanforderungen und vorhandene Infrastruktur werden in der Planung berücksichtigt.',
                            'features' => [
                                'REST- oder vergleichbare Schnittstellen nach Bedarf',
                                'Anbindung bestehender Systeme',
                                'Dokumentation der vereinbarten Endpunkte',
                                'Fehlerbehandlung und grundlegende Tests',
                            ],
                            'seo_title' => 'API-Entwicklung | Tay Reparaturservice',
                            'seo_description' => 'API-Entwicklung und Systemanbindung: Schnittstellen für den kontrollierten Datenaustausch zwischen Anwendungen.',
                        ],
                        'en' => [
                            'name' => 'API Development',
                            'slug' => 'api-development',
                            'excerpt' => 'Interfaces that allow systems to exchange data in a controlled way.',
                            'description' => 'Many technical problems appear because systems cannot talk to each other. We design and maintain APIs so applications, devices or internal services can exchange data in a controlled way. That includes agreeing data models, authentication using an agreed method, documenting endpoints and testing the main paths. Security requirements and existing infrastructure are taken into account during planning.',
                            'features' => [
                                'REST or comparable interfaces as required',
                                'Integration with existing systems',
                                'Documentation of agreed endpoints',
                                'Error handling and essential tests',
                            ],
                            'seo_title' => 'API Development | Tay Reparaturservice',
                            'seo_description' => 'API development and system integration: interfaces for controlled data exchange between applications.',
                        ],
                    ]),
                    $this->service('database-solutions', 'database', [
                        'de' => [
                            'name' => 'Datenbanklösungen',
                            'slug' => 'datenbankloesungen',
                            'excerpt' => 'Daten strukturieren, pflegen, migrieren und in Anwendungen sowie internen Abläufen nutzbar machen.',
                            'description' => 'Wir übernehmen den Umgang mit Daten, wenn Bestände unübersichtlich sind, übernommen, ausgewertet oder an Software angebunden werden müssen: Modellierung, Import und Export, Abfragen, Migration und die Pflege der Strukturen, die Ihre Anwendungen brauchen. Wir arbeiten mit den Systemen, die in Ihrem Umfeld tatsächlich im Einsatz sind, und machen keine pauschalen Aussagen über Performance-Gewinne. Datensicherung, Löschfristen und Zugriffsrechte bleiben in Ihrer Verantwortung, sofern nichts anderes vereinbart wird.',
                            'features' => [
                                'Analyse bestehender Datenstrukturen',
                                'Import, Export und Unterstützung bei Migrationen',
                                'Abfragen, Auswertungen und Anbindung an Anwendungen',
                                'Abstimmung mit Ihrer Softwarelandschaft',
                            ],
                            'seo_title' => 'Datenbanklösungen | Tay Reparaturservice',
                            'seo_description' => 'Datenbankanalyse, Migration und Strukturierung für Anwendungen und interne Prozesse – nach Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Database Solutions',
                            'slug' => 'database-solutions',
                            'excerpt' => 'Structure, care, migrate and make data usable in applications and internal workflows.',
                            'description' => 'We handle data work when stores have become hard to manage, need to be taken over, reported on, or connected to software: modelling, import and export, queries, migration and the structures your applications need. We work with the systems actually in use in your environment and do not make generic claims about performance gains. Backups, retention and access rights remain your responsibility unless agreed otherwise.',
                            'features' => [
                                'Review of existing data structures',
                                'Import, export and support during migrations',
                                'Queries, reports and connections to applications',
                                'Alignment with your software landscape',
                            ],
                            'seo_title' => 'Database Solutions | Tay Reparaturservice',
                            'seo_description' => 'Database analysis, migration and structuring for applications and internal processes — by agreement.',
                        ],
                    ]),
                    $this->service('system-integration', 'share', [
                        'de' => [
                            'name' => 'Systemintegration',
                            'slug' => 'systemintegration',
                            'excerpt' => 'Verbindung vorhandener Anwendungen, Geräte und Datenquellen zu einem nachvollziehbaren Gesamtablauf.',
                            'description' => 'Isolierte Werkzeuge kosten Zeit. Wir helfen dabei, vorhandene Software, Geräte und Datenquellen so zu verbinden, dass Informationen an der richtigen Stelle ankommen. Das kann ein Importprozess, eine Schnittstelle oder eine klar dokumentierte manuelle Übergabe sein – je nachdem, was in Ihrem Fall tragfähig ist. Ziel ist ein nachvollziehbarer Ablauf, nicht eine möglichst große technische Landschaft.',
                            'features' => [
                                'Bestandsaufnahme der beteiligten Systeme',
                                'Technische und organisatorische Übergänge',
                                'Schnittstellen oder geführte Prozesse',
                                'Übergabedokumentation',
                            ],
                            'seo_title' => 'Systemintegration | Tay Reparaturservice',
                            'seo_description' => 'Systemintegration für Unternehmen: vorhandene Anwendungen und Datenquellen sinnvoll verbinden.',
                        ],
                        'en' => [
                            'name' => 'System Integration',
                            'slug' => 'system-integration',
                            'excerpt' => 'Connecting existing applications, devices and data sources into a traceable overall process.',
                            'description' => 'Isolated tools waste time. We help connect existing software, devices and data sources so information arrives where it is needed. That may be an import process, an interface or a clearly documented manual handover — whichever is viable in your case. The goal is a process you can follow, not the largest possible technical landscape.',
                            'features' => [
                                'Inventory of the systems involved',
                                'Technical and organisational handovers',
                                'Interfaces or guided processes',
                                'Handover documentation',
                            ],
                            'seo_title' => 'System Integration | Tay Reparaturservice',
                            'seo_description' => 'System integration for businesses: connecting existing applications and data sources in a practical way.',
                        ],
                    ]),
                    $this->service('automation', 'cpu', [
                        'de' => [
                            'name' => 'Automatisierung',
                            'slug' => 'automatisierung',
                            'excerpt' => 'Wiederkehrende technische Schritte nachvollziehbar automatisieren – dort, wo es den Aufwand lohnt.',
                            'description' => 'Wiederkehrende manuelle Schritte in IT- und Technikprozessen sind fehleranfällig. Wir prüfen, welche Abläufe sich sinnvoll automatisieren lassen, und setzen vereinbarte Automatisierungen um – etwa Importe, Prüfschritte oder Benachrichtigungen. Nicht jeder Prozess eignet sich dafür; das sprechen wir offen an. Die Verantwortung für fachliche Freigaben und rechtliche Prüfungen bleibt beim Auftraggeber.',
                            'features' => [
                                'Identifikation geeigneter Prozessschritte',
                                'Umsetzung vereinbarter Automatisierungen',
                                'Protokollierung wesentlicher Läufe',
                                'Anpassung bei geänderten Abläufen',
                            ],
                            'seo_title' => 'Automatisierung | Tay Reparaturservice',
                            'seo_description' => 'Technische Automatisierung wiederkehrender Abläufe – geprüft, umgesetzt und dokumentiert nach Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Automation',
                            'slug' => 'automation',
                            'excerpt' => 'Automating recurring technical steps where the effort is justified.',
                            'description' => 'Recurring manual steps in IT and technical processes invite mistakes. We review which workflows can reasonably be automated and implement agreed automations — for example imports, checks or notifications. Not every process is a good candidate; we say so plainly. Responsibility for specialist approvals and legal review remains with the client.',
                            'features' => [
                                'Identification of suitable process steps',
                                'Implementation of agreed automations',
                                'Logging of essential runs',
                                'Adjustments when workflows change',
                            ],
                            'seo_title' => 'Automation | Tay Reparaturservice',
                            'seo_description' => 'Technical automation of recurring workflows — reviewed, implemented and documented by agreement.',
                        ],
                    ]),
                    $this->service('software-maintenance', 'wrench', [
                        'de' => [
                            'name' => 'Softwarewartung & Fehlerbehebung',
                            'slug' => 'softwarewartung',
                            'excerpt' => 'Fehler beheben, bestehende Software aktualisieren und vereinbarte Funktionen ergänzen.',
                            'description' => 'Software bleibt selten unverändert. Wir übernehmen Fehleranalyse, Korrekturen, Updates und das gezielte Ergänzen von Funktionen an bestehenden Anwendungen – soweit der technische Zugang und der vereinbarte Umfang das zulassen. Zuerst reproduzieren und eingrenzen wir das Problem oder den Änderungswunsch, dann schlagen wir eine Vorgehensweise vor. Quellcode, Zugänge und Verantwortlichkeiten müssen geklärt sein, bevor Änderungen erfolgen. Eine pauschale Verfügbarkeitszusage ist nicht Bestandteil dieses Angebots.',
                            'features' => [
                                'Fehleranalyse und Reproduktion',
                                'Korrekturen und Updates nach Freigabe',
                                'Ergänzung vereinbarter Funktionen',
                                'Übergabe der Änderungen',
                            ],
                            'seo_title' => 'Softwarewartung | Tay Reparaturservice',
                            'seo_description' => 'Softwarewartung, Fehleranalyse und Bugfixing für bestehende Anwendungen – nach technischer Prüfung und Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Software Maintenance & Bug Fixing',
                            'slug' => 'software-maintenance',
                            'excerpt' => 'Fix faults, update existing software and add agreed features.',
                            'description' => 'Software rarely stays still. We provide fault analysis, corrections, updates and targeted new features for existing applications, within the access and scope that have been agreed. We first reproduce and isolate the issue or the change request, then propose an approach. Source code, access and responsibilities must be clear before changes are made. A blanket availability commitment is not part of this offering.',
                            'features' => [
                                'Fault analysis and reproduction',
                                'Fixes and updates after approval',
                                'Adding agreed features',
                                'Handover of the changes',
                            ],
                            'seo_title' => 'Software Maintenance | Tay Reparaturservice',
                            'seo_description' => 'Software maintenance, fault analysis and bug fixing for existing applications — after technical review and agreement.',
                        ],
                    ]),
                    $this->service('technical-consulting-it', 'compass', [
                        'de' => [
                            'name' => 'Technische IT-Beratung',
                            'slug' => 'technische-beratung',
                            'excerpt' => 'Unabhängige Einschätzung zu Systemen, Abläufen und möglichen nächsten Schritten.',
                            'description' => 'Manchmal ist der nächste Schritt unklar: ein System ist unstabil, eine Anschaffung steht an oder interne Abläufe passen nicht zur vorhandenen Technik. Wir analysieren die Situation, benennen Risiken und schlagen realistische Optionen vor. Die Beratung bleibt unabhängig von konkreten Produktverkäufen. Empfehlungen gelten im Rahmen der uns vorliegenden Informationen; eine Garantie für Drittsysteme übernehmen wir nicht.',
                            'features' => [
                                'Bestands- und Problembetrachtung',
                                'Optionen mit Vor- und Nachteilen',
                                'Priorisierung möglicher Maßnahmen',
                                'Schriftliche Zusammenfassung auf Wunsch',
                            ],
                            'seo_title' => 'Technische IT-Beratung | Tay Reparaturservice',
                            'seo_description' => 'Technische Beratung zu Software, Systemen und IT-Abläufen – klare Einschätzung statt Produktverkauf.',
                        ],
                        'en' => [
                            'name' => 'Technical IT Consulting',
                            'slug' => 'technical-consulting',
                            'excerpt' => 'An independent view of systems, workflows and realistic next steps.',
                            'description' => 'Sometimes the next step is unclear: a system is unstable, a purchase is pending, or internal workflows no longer match the technology in place. We review the situation, name risks and outline realistic options. Consulting is independent of product sales. Recommendations are based on the information available to us; we do not guarantee third-party systems.',
                            'features' => [
                                'Review of the current setup and issues',
                                'Options with advantages and drawbacks',
                                'Prioritisation of possible measures',
                                'Written summary on request',
                            ],
                            'seo_title' => 'Technical IT Consulting | Tay Reparaturservice',
                            'seo_description' => 'Technical consulting on software, systems and IT workflows — a clear assessment rather than a product pitch.',
                        ],
                    ]),
                    $this->service('system-optimization', 'sliders', [
                        'de' => [
                            'name' => 'Systemoptimierung',
                            'slug' => 'systemoptimierung',
                            'excerpt' => 'Bestehende Systeme verständlicher, stabiler und wartbarer machen.',
                            'description' => 'Viele Umgebungen wachsen über Jahre. Wir helfen, bestehende Software- und Systemlandschaften zu ordnen: Konfiguration prüfen, offensichtliche Engpässe identifizieren, Updates planen oder Abläufe vereinfachen. Optimierung bedeutet hier nachvollziehbare Verbesserung im vereinbarten Rahmen – nicht ein Versprechen, dass Systeme danach „maximal schnell“ sind. Messgrößen und Ziele werden vorab festgelegt, soweit sie sich sinnvoll erheben lassen.',
                            'features' => [
                                'Durchsicht von Konfiguration und Abläufen',
                                'Identifikation offensichtlicher Schwachstellen',
                                'Konkrete, umsetzbare Empfehlungen',
                                'Begleitung vereinbarter Änderungen',
                            ],
                            'seo_title' => 'Systemoptimierung | Tay Reparaturservice',
                            'seo_description' => 'Systemoptimierung für bestehende IT-Umgebungen: prüfen, priorisieren und im vereinbarten Rahmen verbessern.',
                        ],
                        'en' => [
                            'name' => 'System Optimization',
                            'slug' => 'system-optimization',
                            'excerpt' => 'Making existing systems clearer, more stable and easier to maintain.',
                            'description' => 'Many environments grow over years. We help bring existing software and system landscapes into order: reviewing configuration, identifying obvious bottlenecks, planning updates or simplifying workflows. Optimization here means a traceable improvement within an agreed scope — not a promise that systems will afterwards be “as fast as possible”. Metrics and goals are defined in advance where they can reasonably be measured.',
                            'features' => [
                                'Review of configuration and workflows',
                                'Identification of obvious weaknesses',
                                'Concrete, actionable recommendations',
                                'Support for agreed changes',
                            ],
                            'seo_title' => 'System Optimization | Tay Reparaturservice',
                            'seo_description' => 'System optimization for existing IT environments: review, prioritise and improve within an agreed scope.',
                        ],
                    ]),
                    $this->service('modern-technologies-ai', 'cpu', [
                        'de' => [
                            'name' => 'Aktuelle Technologien & KI',
                            'slug' => 'aktuelle-technologien-ki',
                            'excerpt' => 'Aktuelle Entwicklungswerkzeuge und KI-gestützte Verfahren, wo sie Analyse, Umsetzung oder Qualität nachweisbar verbessern.',
                            'description' => 'Wir setzen aktuelle Entwicklungswerkzeuge ein, einschließlich KI-gestützter Verfahren, wenn sie helfen, Anforderungen zu klären, Code und Daten zu prüfen oder Ergebnisse nachvollziehbar zu verbessern. KI ersetzt weder fachliche Freigabe noch Tests noch Ihre Verantwortung für Daten. Welche Werkzeuge zum Einsatz kommen, hängt von Aufgabe, Datenschutz und Vereinbarung ab. Ein pauschales Versprechen „bester Ergebnisse“ unabhängig vom Ausgangsmaterial geben wir nicht.',
                            'features' => [
                                'Einsatz aktueller Werkzeuge nach Eignung',
                                'KI-Unterstützung bei Analyse und Umsetzung, wo sinnvoll',
                                'Menschliche Prüfung vor Übergabe',
                                'Abstimmung zu Daten, Geheimhaltung und Umfang',
                            ],
                            'seo_title' => 'Aktuelle Technologien und KI | Tay Reparaturservice',
                            'seo_description' => 'Softwareentwicklung mit aktuellen Werkzeugen und KI-Unterstützung – geprüft, vereinbart und ohne pauschale Erfolgsgarantie.',
                        ],
                        'en' => [
                            'name' => 'Current Technologies & AI',
                            'slug' => 'current-technologies-ai',
                            'excerpt' => 'Current development tools and AI-assisted methods where they measurably improve analysis, implementation or quality.',
                            'description' => 'We use current development tools, including AI-assisted methods, when they help clarify requirements, review code and data, or improve results in a way you can follow. AI does not replace specialist approval, testing or your responsibility for data. Which tools we use depends on the task, data protection and the agreement. We do not promise “best results” regardless of the starting material.',
                            'features' => [
                                'Use of current tools where they fit',
                                'AI support for analysis and implementation where it helps',
                                'Human review before handover',
                                'Agreement on data, confidentiality and scope',
                            ],
                            'seo_title' => 'Current Technologies and AI | Tay Reparaturservice',
                            'seo_description' => 'Software development with current tools and AI assistance — reviewed, agreed and without a blanket success guarantee.',
                        ],
                    ]),
                ],
            ],
            [
                'key' => 'technical-support',
                'icon' => 'headset',
                'translations' => [
                    'de' => [
                        'name' => 'Technischer Support',
                        'slug' => 'technischer-support',
                        'excerpt' => 'Störungsaufnahme, Analyse und Unterstützung bei technischen Systemen – remote oder vor Ort nach Absprache.',
                        'description' => 'Technischer Support bei Tay Reparaturservice bedeutet strukturierte Hilfe: Wir nehmen das Problem auf, grenzen es ein und setzen vereinbarte Maßnahmen um. Das Angebot richtet sich an Privatpersonen und Unternehmen. Remote-Unterstützung und Vor-Ort-Termine sind möglich, sofern Zugang, Sicherheit und Terminlage das zulassen.',
                        'seo_title' => 'Technischer Support | Tay Reparaturservice',
                        'seo_description' => 'Technischer Support für Privat- und Geschäftskunden: Störungsanalyse, Remote-Hilfe und Vor-Ort-Service nach Vereinbarung.',
                    ],
                    'en' => [
                        'name' => 'Technical Support',
                        'slug' => 'technical-support',
                        'excerpt' => 'Incident intake, analysis and support for technical systems — remote or on site by arrangement.',
                        'description' => 'Technical support at Tay Reparaturservice means structured help: we take in the issue, isolate it and carry out agreed measures. The offering is for private individuals and businesses. Remote support and on-site appointments are possible where access, safety and scheduling allow.',
                        'seo_title' => 'Technical Support | Tay Reparaturservice',
                        'seo_description' => 'Technical support for private and business customers: fault analysis, remote help and on-site service by arrangement.',
                    ],
                ],
                'services' => [
                    $this->service('troubleshooting', 'search', [
                        'de' => [
                            'name' => 'Technische Störungsbehebung',
                            'slug' => 'stoerungsbehebung',
                            'excerpt' => 'Systematische Eingrenzung und Behebung technischer Störungen.',
                            'description' => 'Wenn ein Gerät, eine Anwendung oder ein Ablauf nicht mehr wie erwartet funktioniert, beginnen wir mit einer strukturierten Diagnose. Ziel ist, die Ursache einzugrenzen und eine nachvollziehbare nächste Maßnahme vorzuschlagen – Reparatur, Konfiguration, Austausch oder Weiterleitung an den Hersteller, falls das sinnvoller ist. Nicht jede Störung lässt sich vollständig vor Ort oder remote lösen; das teilen wir transparent mit.',
                            'features' => [
                                'Aufnahme der Symptome und Rahmenbedingungen',
                                'Schrittweise Eingrenzung',
                                'Korrektur im vereinbarten Rahmen',
                                'Kurze Dokumentation des Ergebnisses',
                            ],
                            'seo_title' => 'Technische Störungsbehebung | Tay Reparaturservice',
                            'seo_description' => 'Systematische Störungsbehebung für Geräte, Software und technische Abläufe – Diagnose und nächste Schritte klar benannt.',
                        ],
                        'en' => [
                            'name' => 'Technical Troubleshooting',
                            'slug' => 'troubleshooting',
                            'excerpt' => 'Systematic isolation and resolution of technical faults.',
                            'description' => 'When a device, application or process no longer behaves as expected, we start with a structured diagnosis. The aim is to isolate the cause and propose a traceable next step — repair, configuration, replacement or referral to the manufacturer if that is more appropriate. Not every fault can be fully resolved on site or remotely; we say so openly.',
                            'features' => [
                                'Capture of symptoms and context',
                                'Step-by-step isolation',
                                'Correction within the agreed scope',
                                'Brief documentation of the outcome',
                            ],
                            'seo_title' => 'Technical Troubleshooting | Tay Reparaturservice',
                            'seo_description' => 'Systematic troubleshooting for devices, software and technical workflows — diagnosis and next steps clearly stated.',
                        ],
                    ]),
                    $this->service('system-analysis', 'search', [
                        'de' => [
                            'name' => 'Systemanalyse',
                            'slug' => 'systemanalyse',
                            'excerpt' => 'Technische Bestandsaufnahme, um Ursachen und Handlungsoptionen sichtbar zu machen.',
                            'description' => 'Eine Systemanalyse ist sinnvoll, wenn Probleme wiederholt auftreten oder unklar ist, welches Teil der Kette versagt. Wir betrachten Konfiguration, Abläufe, Schnittstellen und – soweit zugänglich – Protokolle. Das Ergebnis ist eine verständliche Einschätzung mit empfohlenen nächsten Schritten, keine automatische Umsetzung. Der Umfang der Analyse wird vorab vereinbart.',
                            'features' => [
                                'Strukturierte Bestandsaufnahme',
                                'Bewertung erkennbarer Risiken',
                                'Priorisierte Handlungsoptionen',
                                'Grundlage für weitere Beauftragung',
                            ],
                            'seo_title' => 'Systemanalyse | Tay Reparaturservice',
                            'seo_description' => 'Technische Systemanalyse: Bestand aufnehmen, Ursachen eingrenzen und nächste Schritte nachvollziehbar vorschlagen.',
                        ],
                        'en' => [
                            'name' => 'System Analysis',
                            'slug' => 'system-analysis',
                            'excerpt' => 'A technical inventory that makes causes and options visible.',
                            'description' => 'A system analysis is useful when issues keep returning or it is unclear which part of the chain is failing. We review configuration, workflows, interfaces and — where accessible — logs. The result is a clear assessment with recommended next steps, not automatic implementation. The scope of the analysis is agreed in advance.',
                            'features' => [
                                'Structured inventory',
                                'Assessment of identifiable risks',
                                'Prioritised options',
                                'A basis for further commissioning',
                            ],
                            'seo_title' => 'System Analysis | Tay Reparaturservice',
                            'seo_description' => 'Technical system analysis: inventory, isolate causes and propose traceable next steps.',
                        ],
                    ]),
                    $this->service('remote-support', 'monitor', [
                        'de' => [
                            'name' => 'Remote-Support',
                            'slug' => 'remote-support',
                            'excerpt' => 'Technische Unterstützung per Fernzugriff, wenn das System und Ihre Freigabe das zulassen.',
                            'description' => 'Viele Konfigurations- und Softwareprobleme lassen sich remote bearbeiten. Voraussetzung sind ein geeigneter Zugang, Ihre ausdrückliche Freigabe und eine stabile Verbindung. Wir nutzen nur Verfahren, die mit Ihnen abgestimmt sind. Remote-Support ersetzt keine Vor-Ort-Arbeit an Hardware, die geöffnet oder geprüft werden muss, und ist kein 24/7-Notdienst, sofern das nicht gesondert vereinbart wird.',
                            'features' => [
                                'Terminierte Remote-Sessions',
                                'Arbeit nur nach Freigabe',
                                'Nachvollziehbare Änderungen',
                                'Kurzes Ergebnisprotokoll',
                            ],
                            'seo_title' => 'Remote-Support | Tay Reparaturservice',
                            'seo_description' => 'Technischer Remote-Support nach Termin und Freigabe – Konfiguration, Diagnose und Softwarehilfe ohne unnötige Anfahrt.',
                        ],
                        'en' => [
                            'name' => 'Remote Support',
                            'slug' => 'remote-support',
                            'excerpt' => 'Technical assistance via remote access where the system and your approval allow it.',
                            'description' => 'Many configuration and software issues can be handled remotely. This requires suitable access, your explicit approval and a stable connection. We only use methods agreed with you. Remote support does not replace on-site work on hardware that must be opened or inspected, and it is not a 24/7 emergency service unless separately agreed.',
                            'features' => [
                                'Scheduled remote sessions',
                                'Work only after approval',
                                'Traceable changes',
                                'A short outcome note',
                            ],
                            'seo_title' => 'Remote Support | Tay Reparaturservice',
                            'seo_description' => 'Technical remote support by appointment and approval — configuration, diagnosis and software help without an unnecessary visit.',
                        ],
                    ]),
                    $this->service('on-site-support', 'map', [
                        'de' => [
                            'name' => 'Vor-Ort-Support',
                            'slug' => 'vor-ort-support',
                            'excerpt' => 'Technische Unterstützung vor Ort, wenn Remote-Arbeit nicht ausreicht.',
                            'description' => 'Vor-Ort-Termine sind sinnvoll bei Hardware, Netzwerken vor Ort, Geräten ohne Fernzugriff oder wenn eine gemeinsame Sichtung schneller zum Ziel führt. Termine, Anfahrt und Leistungsumfang werden individuell vereinbart. Wir führen keine Arbeiten aus, für die besondere gesetzliche Qualifikationen vorgeschrieben sind, sofern uns diese nicht vorliegen. Zugang, Sicherheitshinweise und Ansprechpersonen vor Ort müssen geklärt sein.',
                            'features' => [
                                'Terminabstimmung nach Verfügbarkeit',
                                'Arbeit am vereinbarten Einsatzort',
                                'Abstimmung mit Ihren Ansprechpersonen',
                                'Kurze Einsatzdokumentation',
                            ],
                            'seo_title' => 'Vor-Ort-Support | Tay Reparaturservice',
                            'seo_description' => 'Technischer Vor-Ort-Support nach Vereinbarung – wenn Geräte, Netze oder Abläufe vor Ort geprüft werden müssen.',
                        ],
                        'en' => [
                            'name' => 'On-Site Support',
                            'slug' => 'on-site-support',
                            'excerpt' => 'Technical support on site when remote work is not enough.',
                            'description' => 'On-site appointments are useful for hardware, local networks, devices without remote access, or when a joint inspection reaches a result faster. Dates, travel and scope are agreed individually. We do not carry out work that legally requires qualifications we do not hold. Access, safety instructions and on-site contacts must be clarified in advance.',
                            'features' => [
                                'Scheduling according to availability',
                                'Work at the agreed location',
                                'Coordination with your contacts',
                                'Brief assignment documentation',
                            ],
                            'seo_title' => 'On-Site Support | Tay Reparaturservice',
                            'seo_description' => 'Technical on-site support by arrangement — when devices, networks or workflows need to be inspected locally.',
                        ],
                    ]),
                    $this->service('installation-configuration', 'sliders', [
                        'de' => [
                            'name' => 'Installation & Konfiguration',
                            'slug' => 'installation-konfiguration',
                            'excerpt' => 'Einrichtung und Abstimmung technischer Systeme nach Ihren Vorgaben.',
                            'description' => 'Wir installieren und konfigurieren Software, Geräte und Systeme im vereinbarten Rahmen: Betriebssysteme, Anwendungen, Peripherie oder interne Werkzeuge. Vorab klären wir Voraussetzungen, Lizenzen und gewünschte Einstellungen. Herstellervorgaben und vorhandene Richtlinien in Ihrem Haus werden berücksichtigt, soweit sie uns vorliegen. Die Beschaffung von Lizenzen ist nur enthalten, wenn das ausdrücklich vereinbart wird.',
                            'features' => [
                                'Prüfung der Voraussetzungen',
                                'Installation im vereinbarten Umfang',
                                'Grundkonfiguration nach Vorgabe',
                                'Kurze Einweisung auf Wunsch',
                            ],
                            'seo_title' => 'Installation & Konfiguration | Tay Reparaturservice',
                            'seo_description' => 'Installation und Konfiguration von Software und technischen Systemen – nach Vorgabe und Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Installation & Configuration',
                            'slug' => 'installation-configuration',
                            'excerpt' => 'Setup and alignment of technical systems according to your specifications.',
                            'description' => 'We install and configure software, devices and systems within an agreed scope: operating systems, applications, peripherals or internal tools. We clarify prerequisites, licences and desired settings first. Manufacturer guidance and any internal policies you provide are taken into account. Licence procurement is included only if expressly agreed.',
                            'features' => [
                                'Review of prerequisites',
                                'Installation within the agreed scope',
                                'Basic configuration to specification',
                                'A short walkthrough on request',
                            ],
                            'seo_title' => 'Installation & Configuration | Tay Reparaturservice',
                            'seo_description' => 'Installation and configuration of software and technical systems — to specification and by agreement.',
                        ],
                    ]),
                    $this->service('maintenance-checks', 'clipboard', [
                        'de' => [
                            'name' => 'Wartung & Systemprüfung',
                            'slug' => 'wartung-systempruefung',
                            'excerpt' => 'Regelmäßige oder einmalige technische Checks, um den Zustand nachvollziehbar festzuhalten.',
                            'description' => 'Wartung und Systemprüfungen helfen, den Zustand von Geräten und Software festzuhalten, bevor daraus ein Ausfall wird. Wir führen vereinbarte Prüfschritte durch, notieren Auffälligkeiten und empfehlen Maßnahmen. Das ist keine zertifizierte Inspektion nach Industrienormen und kein Ersatz für gesetzlich vorgeschriebene Prüfungen, sofern solche für Ihre Geräte gelten.',
                            'features' => [
                                'Vereinbarte Prüfpunkte',
                                'Sicht- und Funktionstests im Rahmen',
                                'Festhalten von Auffälligkeiten',
                                'Empfehlung zum weiteren Vorgehen',
                            ],
                            'seo_title' => 'Wartung & Systemprüfung | Tay Reparaturservice',
                            'seo_description' => 'Technische Wartung und Systemchecks nach Vereinbarung – Zustand festhalten und nächste Schritte ableiten.',
                        ],
                        'en' => [
                            'name' => 'Maintenance & System Checks',
                            'slug' => 'maintenance-system-checks',
                            'excerpt' => 'Scheduled or one-off technical checks that record the current state in a traceable way.',
                            'description' => 'Maintenance and system checks help record the condition of devices and software before a failure occurs. We carry out agreed inspection steps, note findings and recommend measures. This is not a certified inspection under industrial standards and does not replace legally required tests where those apply to your equipment.',
                            'features' => [
                                'Agreed inspection points',
                                'Visual and functional tests within scope',
                                'Recording of findings',
                                'Recommendation for next steps',
                            ],
                            'seo_title' => 'Maintenance & System Checks | Tay Reparaturservice',
                            'seo_description' => 'Technical maintenance and system checks by agreement — record the current state and derive next steps.',
                        ],
                    ]),
                ],
            ],
            [
                'key' => 'repair-electronics',
                'icon' => 'cpu',
                'translations' => [
                    'de' => [
                        'name' => 'Reparatur & Elektronik-Service',
                        'slug' => 'reparatur-elektronik',
                        'excerpt' => 'Diagnose und Reparatur von Smartphones, Tablets, Computern und weiterer Elektronik – soweit Teile und Zugang es zulassen.',
                        'description' => 'Der Reparatur- und Elektronik-Service umfasst Diagnose, Komponententausch und Funktionsprüfung. Welche Geräte im Einzelfall repariert werden können, hängt von Zustand, Ersatzteilen und wirtschaftlicher Sinnhaftigkeit ab. Eine Reparatur wird erst nach Prüfung und Abstimmung durchgeführt. Datenverluste lassen sich nicht in jedem Fall ausschließen; wichtige Daten sollten vorab gesichert sein, sofern das Gerät das zulässt.',
                        'seo_title' => 'Reparatur & Elektronik-Service | Tay Reparaturservice',
                        'seo_description' => 'Reparatur von Smartphones, Tablets und Computern sowie Elektronikdiagnose – nach Prüfung und Vereinbarung.',
                    ],
                    'en' => [
                        'name' => 'Repair & Electronics Services',
                        'slug' => 'repair-electronics',
                        'excerpt' => 'Diagnosis and repair of smartphones, tablets, computers and other electronics — where parts and access allow.',
                        'description' => 'Repair and electronics services cover diagnosis, component replacement and functional testing. Which devices can be repaired in a given case depends on condition, spare parts and whether a repair is economically reasonable. Work proceeds only after inspection and agreement. Data loss cannot be ruled out in every case; important data should be backed up beforehand if the device still allows it.',
                        'seo_title' => 'Repair & Electronics Services | Tay Reparaturservice',
                        'seo_description' => 'Repair of smartphones, tablets and computers plus electronics diagnosis — after inspection and agreement.',
                    ],
                ],
                'services' => [
                    $this->service('smartphone-repair', 'smartphone', [
                        'de' => [
                            'name' => 'Smartphone-Reparatur',
                            'slug' => 'smartphone-reparatur',
                            'excerpt' => 'Prüfung und Reparatur von Smartphones, sofern Zustand und Ersatzteile das zulassen.',
                            'description' => 'Wir nehmen Smartphones zur Diagnose entgegen und prüfen, welche Reparatur möglich und sinnvoll ist – etwa Display, Akku, Ladebuchse oder weitere Komponenten, soweit Teile verfügbar sind. Eine verbindliche Aussage erfolgt nach Sichtprüfung, nicht anhand einer Beschreibung allein. Markenunabhängige Reparatur bedeutet nicht, dass jedes Modell oder jeder Schaden bedient werden kann. Original- oder kompatible Teile werden vor dem Einbau mit Ihnen abgestimmt, sofern eine Wahl besteht.',
                            'features' => [
                                'Eingangsdiagnose',
                                'Kostenvorstellung vor der Reparatur',
                                'Komponententausch nach Freigabe',
                                'Funktionstest nach der Arbeit',
                            ],
                            'seo_title' => 'Smartphone-Reparatur | Tay Reparaturservice',
                            'seo_description' => 'Smartphone-Reparatur nach Diagnose: Display, Akku und weitere Komponenten – sofern Teile verfügbar und die Reparatur sinnvoll ist.',
                        ],
                        'en' => [
                            'name' => 'Smartphone Repair',
                            'slug' => 'smartphone-repair',
                            'excerpt' => 'Inspection and repair of smartphones where condition and spare parts allow.',
                            'description' => 'We accept smartphones for diagnosis and assess which repair is possible and reasonable — for example display, battery, charging port or other components, subject to parts availability. A binding statement follows visual inspection, not a description alone. Independent repair does not mean every model or every type of damage can be handled. Original or compatible parts are agreed with you before installation where a choice exists.',
                            'features' => [
                                'Intake diagnosis',
                                'Cost outline before the repair',
                                'Component replacement after approval',
                                'Functional test after the work',
                            ],
                            'seo_title' => 'Smartphone Repair | Tay Reparaturservice',
                            'seo_description' => 'Smartphone repair after diagnosis: display, battery and other components — where parts are available and a repair is reasonable.',
                        ],
                    ]),
                    $this->service('tablet-repair', 'tablet', [
                        'de' => [
                            'name' => 'Tablet-Reparatur',
                            'slug' => 'tablet-reparatur',
                            'excerpt' => 'Diagnose und Instandsetzung von Tablets im Rahmen verfügbarer Teile und Verfahren.',
                            'description' => 'Tablets prüfen wir auf typische Defekte wie Display, Ladeelektronik oder Gehäuse. Der interne Aufbau unterscheidet sich stark nach Modell; deshalb steht am Anfang immer die Diagnose. Wenn eine Reparatur unverhältnismäßig wäre, sagen wir das. Softwareseitige Probleme (Updates, Konten, Sperren) können nur bearbeitet werden, wenn Sie legitimiert Zugriff gewähren.',
                            'features' => [
                                'Modellbezogene Diagnose',
                                'Klärung der Reparaturfähigkeit',
                                'Austausch vereinbarter Teile',
                                'Abschlussprüfung',
                            ],
                            'seo_title' => 'Tablet-Reparatur | Tay Reparaturservice',
                            'seo_description' => 'Tablet-Reparatur nach technischer Prüfung – Display, Ladeprobleme und weitere Defekte im Rahmen verfügbarer Teile.',
                        ],
                        'en' => [
                            'name' => 'Tablet Repair',
                            'slug' => 'tablet-repair',
                            'excerpt' => 'Diagnosis and repair of tablets within available parts and methods.',
                            'description' => 'We inspect tablets for typical faults such as display, charging electronics or housing issues. Internal construction varies widely by model, so diagnosis always comes first. If a repair would be disproportionate, we say so. Software issues (updates, accounts, locks) can only be handled if you provide legitimate access.',
                            'features' => [
                                'Model-specific diagnosis',
                                'Assessment of repairability',
                                'Replacement of agreed parts',
                                'Final inspection',
                            ],
                            'seo_title' => 'Tablet Repair | Tay Reparaturservice',
                            'seo_description' => 'Tablet repair after technical inspection — display, charging issues and other faults within available parts.',
                        ],
                    ]),
                    $this->service('computer-repair', 'monitor', [
                        'de' => [
                            'name' => 'Computer-Reparatur',
                            'slug' => 'computer-reparatur',
                            'excerpt' => 'Diagnose und Instandsetzung von PCs und Notebooks.',
                            'description' => 'Bei Computern und Notebooks kombinieren wir Hardware- und Softwarebetrachtung: Startprobleme, Speicher, Speicherlaufwerke, Kühlung, Betriebssystem oder Peripherie. Nach der Diagnose erhalten Sie einen Vorschlag – Reparatur, Aufrüstung oder, falls sinnvoller, Hinweise zur Neuanschaffung. Datenrettung ist ein eigener, unsicherer Vorgang und nur nach gesonderter Absprache Thema.',
                            'features' => [
                                'Hardware- und Software-Diagnose',
                                'Komponententausch nach Freigabe',
                                'Systeminstallation im vereinbarten Rahmen',
                                'Funktionstest',
                            ],
                            'seo_title' => 'Computer-Reparatur | Tay Reparaturservice',
                            'seo_description' => 'Reparatur und Diagnose von PCs und Notebooks – Hardware, System und Peripherie nach Prüfung und Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Computer Repair',
                            'slug' => 'computer-repair',
                            'excerpt' => 'Diagnosis and repair of PCs and notebooks.',
                            'description' => 'For computers and notebooks we combine hardware and software review: boot issues, memory, drives, cooling, operating system or peripherals. After diagnosis you receive a proposal — repair, upgrade or, if more appropriate, guidance on replacement. Data recovery is a separate, uncertain process and only discussed by special agreement.',
                            'features' => [
                                'Hardware and software diagnosis',
                                'Component replacement after approval',
                                'System installation within the agreed scope',
                                'Functional testing',
                            ],
                            'seo_title' => 'Computer Repair | Tay Reparaturservice',
                            'seo_description' => 'Repair and diagnosis of PCs and notebooks — hardware, system and peripherals after inspection and agreement.',
                        ],
                    ]),
                    $this->service('hardware-diagnostics', 'search', [
                        'de' => [
                            'name' => 'Hardware-Diagnose',
                            'slug' => 'hardware-diagnose',
                            'excerpt' => 'Technische Prüfung, wenn unklar ist, welche Komponente versagt.',
                            'description' => 'Eine Hardware-Diagnose klärt, ob ein Fehler in Gerät, Zubehör, Stromversorgung oder Software liegt. Wir nutzen Sichtprüfung, Funktionstests und – soweit sinnvoll – Mess- oder Testverfahren im Rahmen der vorhandenen Ausstattung. Das Ergebnis ist eine Einschätzung, keine automatische Garantieentscheidung eines Herstellers. Weitere Schritte (Reparatur, Austausch, Einsendung) stimmen wir mit Ihnen ab.',
                            'features' => [
                                'Eingrenzung der Fehlerquelle',
                                'Prüfung wesentlicher Komponenten',
                                'Nachvollziehbares Ergebnis',
                                'Empfehlung zum weiteren Vorgehen',
                            ],
                            'seo_title' => 'Hardware-Diagnose | Tay Reparaturservice',
                            'seo_description' => 'Hardware-Diagnose für Computer, Mobilgeräte und Elektronik – Fehlerquelle eingrenzen, bevor repariert oder getauscht wird.',
                        ],
                        'en' => [
                            'name' => 'Hardware Diagnostics',
                            'slug' => 'hardware-diagnostics',
                            'excerpt' => 'Technical inspection when it is unclear which component is failing.',
                            'description' => 'Hardware diagnostics clarify whether a fault sits in the device, accessories, power supply or software. We use visual inspection, functional tests and — where useful — measurement or test methods within the equipment available. The result is an assessment, not an automatic manufacturer warranty decision. Next steps (repair, replacement, send-in) are agreed with you.',
                            'features' => [
                                'Isolation of the fault source',
                                'Inspection of essential components',
                                'A traceable result',
                                'Recommendation for next steps',
                            ],
                            'seo_title' => 'Hardware Diagnostics | Tay Reparaturservice',
                            'seo_description' => 'Hardware diagnostics for computers, mobile devices and electronics — isolate the fault before repair or replacement.',
                        ],
                    ]),
                    $this->service('component-replacement', 'cpu', [
                        'de' => [
                            'name' => 'Komponententausch',
                            'slug' => 'komponententausch',
                            'excerpt' => 'Austausch defekter Bauteile nach Diagnose und Freigabe.',
                            'description' => 'Wenn die Diagnose einen konkreten Defekt zeigt, tauschen wir die vereinbarte Komponente. Verfügbarkeit, Kompatibilität und Qualität der Teile werden vorher geklärt. Wir verwenden keine Teile, deren Herkunft oder Passung unklar ist. Nach dem Tausch folgt ein Funktionstest der betroffenen Bereiche. Weitergehende Herstellergarantien Dritter bleiben von unserer Arbeit unberührt, sofern der Hersteller nichts anderes festlegt.',
                            'features' => [
                                'Klärung von Teil und Kompatibilität',
                                'Einbau nach Freigabe',
                                'Funktionstest',
                                'Hinweise zur weiteren Nutzung',
                            ],
                            'seo_title' => 'Komponententausch | Tay Reparaturservice',
                            'seo_description' => 'Austausch defekter Komponenten nach Diagnose – abgestimmt, eingebaut und funktionsgeprüft.',
                        ],
                        'en' => [
                            'name' => 'Component Replacement',
                            'slug' => 'component-replacement',
                            'excerpt' => 'Replacement of defective parts after diagnosis and approval.',
                            'description' => 'When diagnosis points to a specific defect, we replace the agreed component. Availability, compatibility and part quality are clarified first. We do not use parts of unclear origin or fit. After replacement we test the affected functions. Third-party manufacturer warranties remain subject to the manufacturer’s own terms.',
                            'features' => [
                                'Clarification of part and compatibility',
                                'Installation after approval',
                                'Functional testing',
                                'Notes on further use',
                            ],
                            'seo_title' => 'Component Replacement | Tay Reparaturservice',
                            'seo_description' => 'Replacement of defective components after diagnosis — agreed, installed and functionally tested.',
                        ],
                    ]),
                    $this->service('data-transfer', 'database', [
                        'de' => [
                            'name' => 'Datenübertragung',
                            'slug' => 'datenuebertragung',
                            'excerpt' => 'Übertragung von Daten zwischen Geräten, soweit Zugang und Zustand das zulassen.',
                            'description' => 'Beim Gerätewechsel oder nach einer Reparatur können Daten übertragen werden – Benutzerdateien, ausgewählte Einstellungen oder Medien, je nach System und Freigabe. Wir setzen voraus, dass Sie berechtigt sind, auf die Daten zuzugreifen. Verschlüsselte, gesperrte oder beschädigte Speicher können eine Übertragung verhindern. Eine vollständige Spiegelung aller Konten und Lizenzen ist nicht in jedem Fall möglich.',
                            'features' => [
                                'Klärung von Quelle, Ziel und Umfang',
                                'Übertragung im vereinbarten Rahmen',
                                'Stichprobenartige Prüfung',
                                'Keine stillschweigende Vollsicherung',
                            ],
                            'seo_title' => 'Datenübertragung | Tay Reparaturservice',
                            'seo_description' => 'Datenübertragung zwischen Geräten nach Berechtigung und technischer Machbarkeit – Umfang vorab vereinbart.',
                        ],
                        'en' => [
                            'name' => 'Data Transfer',
                            'slug' => 'data-transfer',
                            'excerpt' => 'Transfer of data between devices where access and condition allow.',
                            'description' => 'When changing devices or after a repair, data can be transferred — user files, selected settings or media, depending on the system and your approval. We assume you are authorised to access the data. Encrypted, locked or damaged storage can prevent a transfer. A complete mirror of every account and licence is not always possible.',
                            'features' => [
                                'Clarification of source, target and scope',
                                'Transfer within the agreed scope',
                                'Spot checks',
                                'No implied full backup',
                            ],
                            'seo_title' => 'Data Transfer | Tay Reparaturservice',
                            'seo_description' => 'Data transfer between devices subject to authorisation and technical feasibility — scope agreed in advance.',
                        ],
                    ]),
                ],
            ],
            [
                'key' => 'technology-companies',
                'icon' => 'building',
                'translations' => [
                    'de' => [
                        'name' => 'Technischer Service für Technologieunternehmen',
                        'slug' => 'technologieunternehmen',
                        'excerpt' => 'Flexibler technischer Partner für Technologieunternehmen – Unterstützung nach Bedarf, ohne starres Komplettpaket.',
                        'description' => 'Technologieunternehmen brauchen oft zusätzliche technische Kapazität, ohne eine interne Stelle dauerhaft zu schaffen. Tay Reparaturservice kann als externer technischer Servicepartner unterstützen: bei Tests, Diagnose, Support, Installation oder projektbezogener Mithilfe. Umfang, Vertraulichkeit und Schnittstellen werden individuell vereinbart. Wir treten nicht als Ersatz für regulierte Fachplanung oder zertifizierte Produktzulassung auf.',
                        'seo_title' => 'Technischer Service für Technologieunternehmen | Tay Reparaturservice',
                        'seo_description' => 'Externer technischer Servicepartner für Technologieunternehmen: Support, Tests, Diagnose und projektbezogene Unterstützung.',
                    ],
                    'en' => [
                        'name' => 'Technical Services for Technology Companies',
                        'slug' => 'technology-companies',
                        'excerpt' => 'A flexible technical partner for technology companies — support as needed, without a rigid all-in package.',
                        'description' => 'Technology companies often need extra technical capacity without creating a permanent internal role. Tay Reparaturservice can support you as an external technical service partner: testing, diagnosis, support, installation or project-based assistance. Scope, confidentiality and interfaces are agreed individually. We do not replace regulated specialist design or certified product approval.',
                        'seo_title' => 'Technical Services for Technology Companies | Tay Reparaturservice',
                        'seo_description' => 'External technical service partner for technology companies: support, testing, diagnosis and project-based assistance.',
                    ],
                ],
                'services' => [
                    $this->service('tech-partner-support', 'headset', [
                        'de' => [
                            'name' => 'Technische Partnerunterstützung',
                            'slug' => 'technische-partnerunterstuetzung',
                            'excerpt' => 'Ergänzende technische Kapazität für Ihr Team – klar abgegrenzt und flexibel.',
                            'description' => 'Wir unterstützen Technologieunternehmen, wenn interne Ressourcen für Support, Tests oder Inbetriebnahmen nicht ausreichen. Die Zusammenarbeit kann einmalig oder über einen vereinbarten Zeitraum laufen. Sie bleibt ergänzend: Fachliche Produktverantwortung, Roadmap und Kundenbeziehung liegen bei Ihnen. Vertraulichkeit und Zugänge werden vor Arbeitsbeginn geregelt.',
                            'features' => [
                                'Abgestimmter Aufgabenrahmen',
                                'Anbindung an Ihre bestehenden Prozesse',
                                'Regelmäßige Rückmeldung zum Stand',
                                'Keine automatische Übernahme Ihrer Produktverantwortung',
                            ],
                            'seo_title' => 'Technische Partnerunterstützung | Tay Reparaturservice',
                            'seo_description' => 'Technische Unterstützung für Technologieunternehmen als flexibler externer Partner – Umfang und Schnittstellen nach Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Technical Partner Support',
                            'slug' => 'technical-partner-support',
                            'excerpt' => 'Additional technical capacity for your team — clearly scoped and flexible.',
                            'description' => 'We support technology companies when internal resources are not enough for support, testing or commissioning. Collaboration can be one-off or over an agreed period. It remains complementary: product ownership, roadmap and customer relationships stay with you. Confidentiality and access are settled before work starts.',
                            'features' => [
                                'An agreed task frame',
                                'Alignment with your existing processes',
                                'Regular progress updates',
                                'No automatic transfer of product responsibility',
                            ],
                            'seo_title' => 'Technical Partner Support | Tay Reparaturservice',
                            'seo_description' => 'Technical support for technology companies as a flexible external partner — scope and interfaces by agreement.',
                        ],
                    ]),
                    $this->service('hardware-testing', 'cpu', [
                        'de' => [
                            'name' => 'Hardwaretests & Gerätediagnose',
                            'slug' => 'hardwaretests',
                            'excerpt' => 'Funktions- und Fehlertests an Geräten im Rahmen vereinbarter Prüfschritte.',
                            'description' => 'Für Technologieunternehmen führen wir vereinbarte Hardwaretests und Gerätediagnosen durch – etwa Sichtprüfung, Funktionstests oder reproduzierbare Fehlerszenarien. Prüfprotokolle entstehen im vereinbarten Format. Das ist keine akkreditierte Prüfstelle und kein Ersatz für CE-Konformitätsbewertung oder Labornormen, sofern solche für Ihr Produkt vorgeschrieben sind.',
                            'features' => [
                                'Prüfschritte nach Ihrer Vorgabe oder gemeinsamer Abstimmung',
                                'Dokumentation der Ergebnisse',
                                'Rückmeldung zu reproduzierbaren Fehlern',
                                'Keine stillschweigende Zertifizierung',
                            ],
                            'seo_title' => 'Hardwaretests | Tay Reparaturservice',
                            'seo_description' => 'Hardwaretests und Gerätediagnose für Technologieunternehmen – vereinbarte Prüfschritte, dokumentierte Ergebnisse.',
                        ],
                        'en' => [
                            'name' => 'Hardware Testing & Device Diagnostics',
                            'slug' => 'hardware-testing',
                            'excerpt' => 'Functional and fault tests on devices within agreed inspection steps.',
                            'description' => 'For technology companies we carry out agreed hardware tests and device diagnostics — for example visual inspection, functional tests or reproducible fault scenarios. Reports follow the agreed format. This is not an accredited test laboratory and does not replace CE conformity assessment or laboratory standards where those are required for your product.',
                            'features' => [
                                'Inspection steps to your specification or joint agreement',
                                'Documentation of results',
                                'Feedback on reproducible faults',
                                'No implied certification',
                            ],
                            'seo_title' => 'Hardware Testing | Tay Reparaturservice',
                            'seo_description' => 'Hardware testing and device diagnostics for technology companies — agreed inspection steps and documented results.',
                        ],
                    ]),
                    $this->service('system-testing', 'clipboard', [
                        'de' => [
                            'name' => 'Systemtests',
                            'slug' => 'systemtests',
                            'excerpt' => 'Prüfung von Zusammenspiel, Konfiguration und typischen Nutzungspfaden.',
                            'description' => 'Systemtests betrachten nicht nur Einzelgeräte, sondern das Zusammenspiel: Installation, Konfiguration, typische Bedienwege und erkennbare Fehlerbilder. Wir arbeiten nach einem zuvor abgestimmten Testumfang. Automatisierte Teststrecken oder Lasttests sind nur enthalten, wenn sie ausdrücklich beauftragt werden und die Umgebung das hergibt.',
                            'features' => [
                                'Abgestimmter Testumfang',
                                'Nachvollziehbare Testfälle',
                                'Protokoll der Abweichungen',
                                'Übergabe an Ihr Entwicklungsteam',
                            ],
                            'seo_title' => 'Systemtests | Tay Reparaturservice',
                            'seo_description' => 'Systemtests für technische Produkte und Setups – Zusammenspiel prüfen, Abweichungen dokumentieren.',
                        ],
                        'en' => [
                            'name' => 'System Testing',
                            'slug' => 'system-testing',
                            'excerpt' => 'Review of interaction, configuration and typical usage paths.',
                            'description' => 'System testing looks beyond individual devices to how things work together: installation, configuration, typical user paths and identifiable fault patterns. We work to a previously agreed test scope. Automated test suites or load tests are included only if expressly commissioned and the environment supports them.',
                            'features' => [
                                'An agreed test scope',
                                'Traceable test cases',
                                'A log of deviations',
                                'Handover to your development team',
                            ],
                            'seo_title' => 'System Testing | Tay Reparaturservice',
                            'seo_description' => 'System testing for technical products and setups — check interaction and document deviations.',
                        ],
                    ]),
                    $this->service('project-support', 'layers', [
                        'de' => [
                            'name' => 'Technische Projektunterstützung',
                            'slug' => 'technische-projektunterstuetzung',
                            'excerpt' => 'Befristete Mithilfe in technischen Projekten – Installation, Tests, Dokumentation oder Support.',
                            'description' => 'Projekte brauchen oft zusätzliche Hände für klar umrissene Arbeitspakete. Wir übernehmen vereinbarte Aufgaben in technischen Projekten, etwa Inbetriebnahme, Testdurchführung, Dokumentation oder Support in einer definierten Phase. Steuerung, Budgetverantwortung und fachliche Gesamtverantwortung bleiben beim Auftraggeber. Der Einsatz endet mit dem vereinbarten Paket, sofern keine Verlängerung erfolgt.',
                            'features' => [
                                'Arbeitspaket statt offener Dauerrolle',
                                'Abstimmung mit Projektleitung',
                                'Lieferung im vereinbarten Format',
                                'Option auf Anschlussaufgaben',
                            ],
                            'seo_title' => 'Technische Projektunterstützung | Tay Reparaturservice',
                            'seo_description' => 'Projektbezogene technische Unterstützung für Technologieunternehmen – klar umrissene Arbeitspakete nach Vereinbarung.',
                        ],
                        'en' => [
                            'name' => 'Technical Project Support',
                            'slug' => 'technical-project-support',
                            'excerpt' => 'Time-limited assistance in technical projects — installation, testing, documentation or support.',
                            'description' => 'Projects often need extra hands for clearly defined work packages. We take on agreed tasks in technical projects, such as commissioning, test execution, documentation or support in a defined phase. Steering, budget responsibility and overall specialist ownership remain with the client. The assignment ends with the agreed package unless it is extended.',
                            'features' => [
                                'A work package rather than an open-ended role',
                                'Coordination with project lead',
                                'Delivery in the agreed format',
                                'Option of follow-on tasks',
                            ],
                            'seo_title' => 'Technical Project Support | Tay Reparaturservice',
                            'seo_description' => 'Project-based technical support for technology companies — clearly defined work packages by agreement.',
                        ],
                    ]),
                ],
            ],
            [
                'key' => 'business-industry',
                'icon' => 'factory',
                'translations' => [
                    'de' => [
                        'name' => 'Technischer Service für Unternehmen, Labore & Industrie',
                        'slug' => 'unternehmen-labore-industrie',
                        'excerpt' => 'Individuelle technische Dienstleistungen nach Bedarf und Vereinbarung – für Betriebe, Labore und industrielle Umgebungen.',
                        'description' => 'Unternehmen, Labore und industrielle Betriebe benötigen technische Unterstützung, die sich in bestehende Abläufe einfügt. Tay Reparaturservice bietet individuelle technische Dienstleistungen nach Bedarf und Vereinbarung: Wartung im vereinbarten Rahmen, Diagnose, Installation, Dokumentation oder Vor-Ort-Unterstützung. Wir übernehmen keine regulierten Prüfungen, sicherheitstechnischen Abnahmen oder Ingenieurleistungen, für die besondere Befähigungen gesetzlich vorgeschrieben sind, sofern uns diese nicht vorliegen.',
                        'seo_title' => 'Technischer Service für Unternehmen, Labore & Industrie | Tay Reparaturservice',
                        'seo_description' => 'Individuelle technische Dienstleistungen für Betriebe, Labore und Industrie – nach Bedarf und Vereinbarung, ohne unzutreffende Zertifizierungsversprechen.',
                    ],
                    'en' => [
                        'name' => 'Technical Services for Businesses, Laboratories & Industry',
                        'slug' => 'businesses-laboratories-industry',
                        'excerpt' => 'Customized technical services based on individual requirements and agreement — for businesses, laboratories and industrial environments.',
                        'description' => 'Businesses, laboratories and industrial operations need technical support that fits existing workflows. Tay Reparaturservice provides customized technical services based on individual requirements and agreement: maintenance within an agreed scope, diagnosis, installation, documentation or on-site support. We do not carry out regulated inspections, safety approvals or engineering work that legally requires qualifications we do not hold.',
                        'seo_title' => 'Technical Services for Businesses, Laboratories & Industry | Tay Reparaturservice',
                        'seo_description' => 'Customized technical services for businesses, laboratories and industry — by requirement and agreement, without unsupported certification claims.',
                    ],
                ],
                'services' => [
                    $this->service('industrial-maintenance', 'wrench', [
                        'de' => [
                            'name' => 'Technische Wartung nach Vereinbarung',
                            'slug' => 'technische-wartung',
                            'excerpt' => 'Wartungs- und Prüfarbeiten im ausdrücklich vereinbarten, nicht regulierten Rahmen.',
                            'description' => 'Wir führen technische Wartungsarbeiten aus, die zuvor schriftlich oder in der Auftragsbestätigung beschrieben wurden: Sichtprüfung, einfache Funktionstests, Austausch verschleißender Teile, soweit uns das Gerät, die Dokumentation und die Qualifikation das erlauben. Gesetzlich vorgeschriebene Prüfungen (zum Beispiel bestimmte sicherheitstechnische wiederkehrende Prüfungen) sind nur dann Gegenstand, wenn das gesondert und rechtlich zulässig vereinbart wird. Im Zweifel benennen wir die Grenze unseres Auftrags klar.',
                            'features' => [
                                'Leistungsbeschreibung vor Arbeitsbeginn',
                                'Arbeit an freigegebenen Anlagen oder Geräten',
                                'Dokumentation im vereinbarten Umfang',
                                'Keine stillschweigende Übernahme regulierter Prüfpflichten',
                            ],
                            'seo_title' => 'Technische Wartung | Tay Reparaturservice',
                            'seo_description' => 'Technische Wartung für Betriebe nach Vereinbarung – klar beschriebener Umfang, ohne unzutreffende Normversprechen.',
                        ],
                        'en' => [
                            'name' => 'Technical Maintenance by Agreement',
                            'slug' => 'technical-maintenance',
                            'excerpt' => 'Maintenance and inspection work within an expressly agreed, non-regulated scope.',
                            'description' => 'We carry out technical maintenance that has been described in writing or in the order confirmation: visual inspection, simple functional tests, replacement of wear parts, where the device, documentation and our qualifications allow. Legally required inspections (for example certain recurring safety tests) are only included if separately and lawfully agreed. In case of doubt we state the limit of the assignment clearly.',
                            'features' => [
                                'A description of work before it starts',
                                'Work on approved equipment or devices',
                                'Documentation within the agreed scope',
                                'No implied takeover of regulated inspection duties',
                            ],
                            'seo_title' => 'Technical Maintenance | Tay Reparaturservice',
                            'seo_description' => 'Technical maintenance for businesses by agreement — a clearly described scope, without unsupported standards claims.',
                        ],
                    ]),
                    $this->service('equipment-inspection', 'clipboard', [
                        'de' => [
                            'name' => 'Geräteprüfung & Diagnose',
                            'slug' => 'geraetepruefung',
                            'excerpt' => 'Technische Sichtung und Diagnose von Geräten in betrieblichen Umgebungen.',
                            'description' => 'In Betrieben und Laboren klären wir technische Auffälligkeiten an Geräten, soweit Zugang und Sicherheitsvorgaben das zulassen. Die Diagnose dient der Entscheidungsgrundlage: weiterbetreiben mit Hinweis, instand setzen, herstellerseitig prüfen lassen oder außer Betrieb nehmen. Wir ersetzen keine akkreditierte Kalibrierung und keine messstellenbezogene Zertifizierung.',
                            'features' => [
                                'Sichtung unter Beachtung Ihrer Sicherheitsregeln',
                                'Eingrenzung erkennbarer Fehler',
                                'Handlungsempfehlung',
                                'Abgrenzung zu Kalibrier- und Zulassungsstellen',
                            ],
                            'seo_title' => 'Geräteprüfung | Tay Reparaturservice',
                            'seo_description' => 'Technische Geräteprüfung und Diagnose für Betriebe und Labore – Entscheidungsgrundlage nach Sichtung, ohne Kalibrierversprechen.',
                        ],
                        'en' => [
                            'name' => 'Equipment Inspection & Diagnostics',
                            'slug' => 'equipment-inspection',
                            'excerpt' => 'Technical inspection and diagnosis of equipment in operational environments.',
                            'description' => 'In businesses and laboratories we investigate technical issues on equipment where access and safety rules allow. Diagnosis supports a decision: continue with a note, repair, have the manufacturer inspect, or take out of service. We do not replace accredited calibration or measurement-point certification.',
                            'features' => [
                                'Inspection in line with your safety rules',
                                'Isolation of identifiable faults',
                                'A recommended course of action',
                                'A clear boundary versus calibration and approval bodies',
                            ],
                            'seo_title' => 'Equipment Inspection | Tay Reparaturservice',
                            'seo_description' => 'Technical equipment inspection and diagnosis for businesses and laboratories — a decision basis after inspection, without calibration claims.',
                        ],
                    ]),
                    $this->service('on-site-technical', 'map', [
                        'de' => [
                            'name' => 'Vor-Ort-Service für Betriebe',
                            'slug' => 'vor-ort-service-betriebe',
                            'excerpt' => 'Technische Einsätze an Ihrem Standort nach Termin, Zugang und Sicherheitsabstimmung.',
                            'description' => 'Vor-Ort-Service für Unternehmen, Werkstätten, Labore oder Produktionsumgebungen setzt klare Spielregeln voraus: Ansprechperson, Zutritt, Schutzausrüstung und erlaubte Tätigkeiten. Wir halten uns an die von Ihnen genannten Standortregeln. Arbeiten an Anlagen mit besonderem Gefahrenpotenzial erfolgen nur, wenn das ausdrücklich im Auftrag steht und rechtlich zulässig ist. Anfahrt und Einsatzzeit werden vorab kalkuliert.',
                            'features' => [
                                'Termin und Einsatzort nach Vereinbarung',
                                'Einhaltung Ihrer Standortvorgaben',
                                'Technische Arbeit im beschriebenen Rahmen',
                                'Kurzer Einsatzbericht',
                            ],
                            'seo_title' => 'Vor-Ort-Service für Betriebe | Tay Reparaturservice',
                            'seo_description' => 'Technischer Vor-Ort-Service für Unternehmen, Labore und Betriebe – nach Termin, Zugang und vereinbartem Leistungsumfang.',
                        ],
                        'en' => [
                            'name' => 'On-Site Service for Businesses',
                            'slug' => 'on-site-service-businesses',
                            'excerpt' => 'Technical assignments at your site after scheduling, access and safety alignment.',
                            'description' => 'On-site service for companies, workshops, laboratories or production environments requires clear rules: a contact person, access, protective equipment and permitted activities. We follow the site rules you provide. Work on equipment with particular hazard potential takes place only if it is expressly in the order and legally permitted. Travel and time on site are estimated in advance.',
                            'features' => [
                                'Date and location by agreement',
                                'Compliance with your site rules',
                                'Technical work within the described scope',
                                'A short assignment report',
                            ],
                            'seo_title' => 'On-Site Service for Businesses | Tay Reparaturservice',
                            'seo_description' => 'Technical on-site service for companies, laboratories and operations — by appointment, access and agreed scope.',
                        ],
                    ]),
                    $this->service('custom-technical', 'layers', [
                        'de' => [
                            'name' => 'Individuelle technische Lösungen',
                            'slug' => 'individuelle-technische-loesungen',
                            'excerpt' => 'Individuelle technische Dienstleistungen nach Bedarf und Vereinbarung.',
                            'description' => 'Nicht jeder betriebliche Bedarf passt in eine Leistungskategorie. Wenn Sie eine technische Aufgabe haben, die Abstimmung braucht – Kombination aus Diagnose, Anpassung, Dokumentation und Support – klären wir zuerst, ob wir sie verantworten können. Anschließend beschreiben wir den Umfang schriftlich. Individuelle technische Dienstleistungen nach Bedarf und Vereinbarung bedeuten: kein pauschales Industrieversprechen, sondern ein klar begrenzter Auftrag.',
                            'features' => [
                                'Klärung von Ziel und Grenzen',
                                'Schriftliche Leistungsbeschreibung',
                                'Umsetzung im vereinbarten Rahmen',
                                'Übergabe inkl. wesentlicher Hinweise',
                            ],
                            'seo_title' => 'Individuelle technische Lösungen | Tay Reparaturservice',
                            'seo_description' => 'Individuelle technische Dienstleistungen nach Bedarf und Vereinbarung – für Betriebe, Labore und industrielle Umgebungen.',
                        ],
                        'en' => [
                            'name' => 'Customized Technical Solutions',
                            'slug' => 'customized-technical-solutions',
                            'excerpt' => 'Customized technical services based on individual requirements and agreement.',
                            'description' => 'Not every operational need fits a service category. If you have a technical task that requires coordination — a mix of diagnosis, adaptation, documentation and support — we first check whether we can take responsibility for it. We then describe the scope in writing. Customized technical services based on individual requirements and agreement means a clearly bounded assignment, not a generic industrial promise.',
                            'features' => [
                                'Clarification of goal and limits',
                                'A written description of work',
                                'Implementation within the agreed scope',
                                'Handover including essential notes',
                            ],
                            'seo_title' => 'Customized Technical Solutions | Tay Reparaturservice',
                            'seo_description' => 'Customized technical services based on individual requirements and agreement — for businesses, laboratories and industrial environments.',
                        ],
                    ]),
                ],
            ],
        ];
    }

    /**
     * @param  array<string, array<string, mixed>>  $translations
     * @return array<string, mixed>
     */
    private function service(string $key, string $icon, array $translations): array
    {
        return [
            'key' => $key,
            'icon' => $icon,
            'translations' => $translations,
        ];
    }
}
