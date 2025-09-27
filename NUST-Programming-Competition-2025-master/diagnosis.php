<?php
// diagnosis.php
session_start();

// Language configuration
$languages = [
    'en' => ['name' => 'English', 'flag' => '🇺🇸'],
    'af' => ['name' => 'Afrikaans', 'flag' => '🇿🇦'],
    'hz' => ['name' => 'Otsiherero', 'flag' => '🇳🇦'],
    'ng' => ['name' => 'Oshiwambo', 'flag' => '🇳🇦']
];

// Set default language
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en';
}

// Handle language change
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $languages)) {
    $_SESSION['language'] = $_GET['lang'];
    header('Location: diagnosis.php');
    exit;
}

// Language strings
$translations = [
    'en' => [
        'title' => 'AI-Powered Diagnosis | MESMTF',
        'diagnosis_title' => 'AI-Powered Diagnosis',
        'diagnosis_subtitle' => 'Get a preliminary assessment for various diseases using our expert system',
        'symptom_checker' => 'Symptom Checker',
        'symptom_instruction' => 'Select the symptoms you\'re experiencing. Our AI system will analyze them and provide a preliminary assessment.',
        'malaria_symptoms' => 'Malaria Symptoms',
        'typhoid_symptoms' => 'Typhoid Symptoms',
        'other_diseases' => 'Other Diseases',
        'tuberculosis' => 'Tuberculosis (TB)',
        'general_symptoms' => 'General Symptoms',
        'very_strong' => 'Very Strong Signs',
        'strong' => 'Strong Signs',
        'weak' => 'Weak Signs',
        'very_weak' => 'Very Weak Signs',
        'analyze_symptoms' => 'Analyze Symptoms',
        'preliminary_diagnosis' => 'Preliminary Diagnosis',
        'assessment' => 'Assessment',
        'suggestion' => 'Suggestion',
        'detailed_results' => 'Detailed Results',
        'probability' => 'Probability',
        'treatment' => 'Treatment',
        'prevention' => 'Prevention',
        'book_appointment' => 'Book Appointment with Doctor',
        'new_diagnosis' => 'Start New Diagnosis',
        'disclaimer' => 'Disclaimer',
        'disclaimer_text' => 'This is a preliminary assessment based on an AI expert system. It is not a substitute for professional medical diagnosis. Please consult a healthcare professional for accurate diagnosis and treatment.',
        'home' => 'Home',
        'about' => 'About',
        'services' => 'Services',
        'diagnosis' => 'Diagnosis',
        'login' => 'Login',
        'register' => 'Register',
        'footer_about' => 'Medical Expert System for Malaria and Typhoid Fever - A comprehensive e-Health solution for the Ministry of Health and Social Services.',
        'quick_links' => 'Quick Links',
        'contact_us' => 'Contact Us',
        'rights_reserved' => 'All rights reserved.',
        'developed_for' => 'Developed for Ministry of Health and Social Services'
    ],
    'af' => [
        'title' => 'AI-aangedrewe Diagnose | MESMTF',
        'diagnosis_title' => 'AI-aangedrewe Diagnose',
        'diagnosis_subtitle' => 'Kry \'n voorlopige assessering vir verskeie siektes deur ons kundige stelsel te gebruik',
        'symptom_checker' => 'Simptoom Kontroleerder',
        'symptom_instruction' => 'Kies die simptome wat jy ervaar. Ons AI-stelsel sal dit ontleed en \'n voorlopige assessering verskaf.',
        'malaria_symptoms' => 'Malaria Simptome',
        'typhoid_symptoms' => 'Tifus Simptome',
        'other_diseases' => 'Ander Siektes',
        'tuberculosis' => 'Tuberkulose (TB)',
        'general_symptoms' => 'Algemene Simptome',
        'very_strong' => 'Baie Sterk Tekens',
        'strong' => 'Sterk Tekens',
        'weak' => 'Swaak Tekens',
        'very_weak' => 'Baie Swaak Tekens',
        'analyze_symptoms' => 'Ontleed Simptome',
        'preliminary_diagnosis' => 'Voorlopige Diagnose',
        'assessment' => 'Assessering',
        'suggestion' => 'Voorstel',
        'detailed_results' => 'Gedetailleerde Resultate',
        'probability' => 'Waarskynlikheid',
        'treatment' => 'Behandeling',
        'prevention' => 'Voorkoming',
        'book_appointment' => 'Bespreek Afspraak met Dokter',
        'new_diagnosis' => 'Begin Nuwe Diagnose',
        'disclaimer' => 'Vrywaring',
        'disclaimer_text' => 'Hierdie is \'n voorlopige assessering gebaseer op \'n AI-kundige stelsel. Dit is nie \'n plaasvervanger vir professionele mediese diagnose nie. Raadpleeg asseblief \'n gesondheidsorgpraktisyn vir akkurate diagnose en behandeling.',
        'home' => 'Tuis',
        'about' => 'Oor',
        'services' => 'Dienste',
        'diagnosis' => 'Diagnose',
        'login' => 'Teken In',
        'register' => 'Registreer',
        'footer_about' => 'Mediese Kundige Stelsel vir Malaria en Tifus Koors - \'n Omvattende e-Gesondheid oplossing vir die Ministerie van Gesondheid en Maatskaplike Dienste.',
        'quick_links' => 'Vinnige Skakels',
        'contact_us' => 'Kontak Ons',
        'rights_reserved' => 'Alle regte voorbehou.',
        'developed_for' => 'Ontwikkel vir Ministerie van Gesondheid en Maatskaplike Dienste'
    ],
    'hz' => [
        'title' => 'AI-Ṱuninḓa Okuṱaṱa | MESMTF',
        'diagnosis_title' => 'AI-Ṱuninḓa Okuṱaṱa',
        'diagnosis_subtitle' => 'Vanga okuṱaṱa kwomatjangero womatjato mbya tji wa ṱunakanḓa sisteme yetu yovayendi',
        'symptom_checker' => 'Okuṱaṱa Kwomatjato',
        'symptom_instruction' => 'Hendura omatjato mbe wa ṱunakanḓa. Sisteme yetu ya AI tja i ṱunakanḓa oyo na ku ṱuninḓa okuṱaṱa kwomatjangero.',
        'malaria_symptoms' => 'Omatjato waMalaria',
        'typhoid_symptoms' => 'Omatjato waTyphoid',
        'other_diseases' => 'Omatjato Wombandi',
        'tuberculosis' => 'Tuberculosis (TB)',
        'general_symptoms' => 'Omatjato Wovandu',
        'very_strong' => 'Omaṱiṱiṱi Maṱiṱi',
        'strong' => 'Omaṱiṱiṱi',
        'weak' => 'Omaṱiṱiṱi Maṱiṱi Nawa',
        'very_weak' => 'Omaṱiṱiṱi Maṱiṱi Nawa Kuru',
        'analyze_symptoms' => 'Ṱunakanḓa Omatjato',
        'preliminary_diagnosis' => 'Okuṱaṱa Kwomatjangero',
        'assessment' => 'Okuṱaṱa',
        'suggestion' => 'Eindulo',
        'detailed_results' => 'Omuinyo Wozonḓera',
        'probability' => 'Okuṱaṱa',
        'treatment' => 'Okuḓukisa',
        'prevention' => 'Okuṱiṱiṱifa',
        'book_appointment' => 'Bookera Ondjendo nomundangi',
        'new_diagnosis' => 'Ṱa Okuṱaṱa Kouṱuku',
        'disclaimer' => 'Eindulo',
        'disclaimer_text' => 'Oku otji oruṱaṱa rwomatjangero rotjirongo motjirongo sisteme ya AI. Ka i yandje komundangi. Ame coka okukondja nomundangi wouṱiki wokuṱaṱa noukuḓukisa.',
        'home' => 'Onganda',
        'about' => 'Meṱeṱero',
        'services' => 'Omiṱiriro',
        'diagnosis' => 'Okuṱaṱa',
        'login' => 'Ingura',
        'register' => 'Tjaṱa',
        'footer_about' => 'Sisteme Yovayendi Yomiti yoMalaria naTyphoid - Eindulo lyokukora eHealth kombeḓa yeMinistre youṱiki nowotjirongo.',
        'quick_links' => 'Omaṱaṱero Wombangu',
        'contact_us' => 'Tjaṱa Omake',
        'rights_reserved' => 'Omaueo ose a zirwe.',
        'developed_for' => 'Tjarwa kombeḓa yeMinistre youṱiki nowotjirongo'
    ],
    'ng' => [
        'title' => 'AI-Okukwatathana Oshiponga | MESMTF',
        'diagnosis_title' => 'AI-Okukwatathana Oshiponga',
        'diagnosis_subtitle' => 'Mona okukwatathana koshiponga shiingoka sho system yetu yoopalekende',
        'symptom_checker' => 'Omapekapeko Oshiponga',
        'symptom_instruction' => 'Hokolola omapekapeko oshowo owa li nago. System yetu ya AI otayi hokolola oyo na okupa okukwatathana koshiponga.',
        'malaria_symptoms' => 'Omapekapeko oMalaria',
        'typhoid_symptoms' => 'Omapekapeko oTyphoid',
        'other_diseases' => 'Oshiponga Shingopa',
        'tuberculosis' => 'Tuberculosis (TB)',
        'general_symptoms' => 'Omapekapeko Oshivike',
        'very_strong' => 'Omapekapeko Omaholike Unene',
        'strong' => 'Omapekapeko Omaholike',
        'weak' => 'Omapekapeko Omatuke',
        'very_weak' => 'Omapekapeko Omatuke Unene',
        'analyze_symptoms' => 'Hokolola Omapekapeko',
        'preliminary_diagnosis' => 'Okukwatathana Koshiponga',
        'assessment' => 'Okukwatathana',
        'suggestion' => 'Eindhila',
        'detailed_results' => 'Omapekaapeko Oshiziwene',
        'probability' => 'Okukala',
        'treatment' => 'Okuyandja',
        'prevention' => 'Okuingila',
        'book_appointment' => 'Booka Omutumba nogonganga',
        'new_diagnosis' => 'Tha Mo Okukwatathana Shopya',
        'disclaimer' => 'Eindhila',
        'disclaimer_text' => 'Oku otashi ka okukwatathana koshiponga shi system ya AI. Kai yi yandje konganga. Indila okukongela konganga wokukwatathana nokuyandja shi shoka.',
        'home' => 'Kwegumbo',
        'about' => 'Omahokololo',
        'services' => 'Omafandjamo',
        'diagnosis' => 'Okukwatathana',
        'login' => 'Ingena',
        'register' => 'Thasitha',
        'footer_about' => 'System Yoopalekende Yomalaria naTyphoid - Eindhila lyokukora eHealth kombelela yeMinistry youkongo nohwepo.',
        'quick_links' => 'Omaandjandja Omapyopyo',
        'contact_us' => 'Thathana Natu',
        'rights_reserved' => 'Omaiyuvo ose a zi.',
        'developed_for' => 'Tungwa kombelela yeMinistry youkongo nohwepo'
    ]
];

// Get current language strings
$lang = $_SESSION['language'];
$t = $translations[$lang];

// Define symptom weights (Very Strong, Strong, Weak, Very Weak)
$symptomWeights = [
    'malaria' => [
        'abdominal_pain' => 4,
        'vomiting' => 4,
        'sore_throat' => 4,
        'headache' => 3,
        'fatigue' => 3,
        'cough' => 3,
        'constipation' => 3,
        'chest_pain' => 2,
        'back_pain' => 2,
        'muscle_pain' => 2,
        'diarrhea' => 1,
        'sweating' => 1,
        'rash' => 1,
        'loss_of_appetite' => 1
    ],
    'typhoid' => [
        'abdominal_pain' => 4,
        'stomach_issues' => 4,
        'headache' => 3,
        'persistent_fever' => 3,
        'weakness' => 2,
        'tiredness' => 2,
        'rash' => 1,
        'loss_of_appetite' => 1
    ],
    'tuberculosis' => [
        'persistent_cough' => 4,
        'chest_pain' => 3,
        'coughing_blood' => 4,
        'fatigue' => 2,
        'fever' => 2,
        'night_sweats' => 3,
        'weight_loss' => 3
    ]
];

// Disease information
$diseaseInfo = [
    'malaria' => [
        'name' => $lang == 'en' ? 'Malaria' : ($lang == 'af' ? 'Malaria' : ($lang == 'hz' ? 'Malaria' : 'Malaria')),
        'description' => $lang == 'en' ? 'A mosquito-borne infectious disease caused by Plasmodium parasites.' : 
                        ($lang == 'af' ? '\'n Muskiet-gedraagde aansteeklike siekte veroorsaak deur Plasmodium-parasiete.' :
                        ($lang == 'hz' ? 'Ondjenda yoḓoroka tji ya ṱururwa kombutu tji ya tungwa koPlasmodium.' :
                        'Oshilwadhi shokufa shi shika sha tungwa koPlasmodium.')),
        'treatment' => $lang == 'en' ? 'Antimalarial medications such as chloroquine, artemisinin-based combination therapies (ACTs), or quinine.' :
                      ($lang == 'af' ? 'Antimalaria-medikasie soos chlorokien, artemisinien-gebaseerde kombinasie-terapieë (ACT\'s), of kinien.' :
                      ($lang == 'hz' ? 'Omiti womalaria mbya chloroquine, artemisinin, ACTs, na quinine.' :
                      'Omuti womalaria mwa chloroquine, artemisinin, ACTs, na quinine.')),
        'prevention' => $lang == 'en' ? 'Use mosquito nets, insect repellents, and take prophylactic medications when traveling to endemic areas.' :
                       ($lang == 'af' ? 'Gebruik muskietnette, insekafweermiddels, en neem profylaktiese medikasie wanneer jy na endemiese areas reis.' :
                       ($lang == 'hz' ? 'Ṱunakanḓa ombutu, omiti wokuminyakisa ovipuka, na ku nwa omiti tji wa yenda kovandu vomalaria.' :
                       'Shilikifa ombutu, shilikifa ovipuka, na nwa omuti tshi wa enda kovandu vomalaria.'))
    ],
    'typhoid' => [
        'name' => $lang == 'en' ? 'Typhoid Fever' : ($lang == 'af' ? 'Tifuskoors' : ($lang == 'hz' ? 'Typhoid' : 'Typhoid')),
        'description' => $lang == 'en' ? 'A bacterial infection caused by Salmonella Typhi that spreads through contaminated food and water.' :
                        ($lang == 'af' ? '\'n Bakteriële infeksie veroorsaak deur Salmonella Typhi wat versprei deur besmette voedsel en water.' :
                        ($lang == 'hz' ? 'Ondjenda yoḓoroka tji ya tungwa koSalmonella Typhi tji yi enda momeya nowomeva.' :
                        'Oshilwadhi sha bakteri sha tungwa koSalmonella Typhi shi shika sha enda momeya nowomeva.')),
        'treatment' => $lang == 'en' ? 'Antibiotics such as azithromycin, ciprofloxacin, or ceftriaxone.' :
                      ($lang == 'af' ? 'Antibiotika soos asitromisien, siprofloksasien, of seftriaksoon.' :
                      ($lang == 'hz' ? 'Omitye wokurandja ombari mbya azithromycin, ciprofloxacin, na ceftriaxone.' :
                      'Omitye wokurandja ombari mwa azithromycin, ciprofloxacin, na ceftriaxone.')),
        'prevention' => $lang == 'en' ? 'Practice good hygiene, drink safe water, and get vaccinated if traveling to high-risk areas.' :
                       ($lang == 'af' ? 'Beoefen goeie higiëne, drink veilige water, en word ingeënt as jy na hoërisiko-areas reis.' :
                       ($lang == 'hz' ? 'Ṱunakanḓa okuyogora, nwa omeva wokure, na ku ṱa omitye tji wa yenda kovandu vokure.' :
                       'Shilikifa okuyogora, nwa omeva wokure, na ṱa omuti tshi wa enda kovandu vokure.'))
    ],
    'tuberculosis' => [
        'name' => $lang == 'en' ? 'Tuberculosis (TB)' : ($lang == 'af' ? 'Tuberkulose (TB)' : ($lang == 'hz' ? 'Tuberculosis (TB)' : 'Tuberculosis (TB)')),
        'description' => $lang == 'en' ? 'A serious infectious disease that mainly affects the lungs, caused by Mycobacterium tuberculosis.' :
                        ($lang == 'af' ? '\'n Ernstige aansteeklike siekte wat hoofsaaklik die longe aantas, veroorsaak deur Mycobacterium tuberculosis.' :
                        ($lang == 'hz' ? 'Ondjenda yoḓoroka mbiṱi tji yi ṱunakanḓa omapunga, tji ya tungwa koMycobacterium tuberculosis.' :
                        'Oshilwadhi shokufa shi shika sha tungwa koMycobacterium tuberculosis.')),
        'treatment' => $lang == 'en' ? 'A course of antibiotics for several months, typically including isoniazid, rifampin, ethambutol, and pyrazinamide.' :
                      ($lang == 'af' ? '\'n Kursus antibiotika vir etlike maande, tipies insluitend isoniasied, rifampien, etambutoel en pirasienamied.' :
                      ($lang == 'hz' ? 'Omitye wokurandja ombari kovili vyomave, mbya isoniazid, rifampin, ethambutol, na pyrazinamide.' :
                      'Omitye wokurandja ombari kovili vyomave, mwa isoniazid, rifampin, ethambutol, na pyrazinamide.')),
        'prevention' => $lang == 'en' ? 'Vaccination (BCG), good ventilation, and avoiding close contact with infected individuals.' :
                       ($lang == 'af' ? 'Inenting (BCG), goeie ventilasie, en vermy nou kontak met besmette individue.' :
                       ($lang == 'hz' ? 'Okuṱa omitye (BCG), ombepo mwaṱi, na ku ṱaṱa okukatja novandu voḓoroka.' :
                       'Okuṱa omuti (BCG), ombepo mwaṱi, na ṱaṱa okukatja novandu vokufa.'))
    ]
];

// Process form submission
$diagnosisResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedSymptoms = $_POST['symptoms'] ?? [];
    $diagnosisResult = performDiagnosis($selectedSymptoms, $symptomWeights);
}

/**
 * Perform diagnosis based on selected symptoms
 */
function performDiagnosis($selectedSymptoms, $symptomWeights) {
    $scores = [];
    
    // Calculate scores for each disease
    foreach ($symptomWeights as $disease => $symptoms) {
        $scores[$disease] = 0;
        foreach ($selectedSymptoms as $symptom) {
            if (isset($symptoms[$symptom])) {
                $scores[$disease] += $symptoms[$symptom];
            }
        }
    }
    
    // Calculate maximum possible scores for normalization
    $maxScores = [];
    foreach ($symptomWeights as $disease => $symptoms) {
        $maxScores[$disease] = array_sum($symptoms);
    }
    
    // Normalize scores and calculate probabilities
    $results = [];
    $totalScore = array_sum($scores);
    
    foreach ($scores as $disease => $score) {
        if ($maxScores[$disease] > 0) {
            $normalizedScore = ($score / $maxScores[$disease]) * 100;
            $results[$disease] = [
                'score' => $score,
                'max_score' => $maxScores[$disease],
                'probability' => $totalScore > 0 ? ($score / $totalScore) * 100 : 0,
                'normalized_score' => $normalizedScore
            ];
        }
    }
    
    // Sort by probability (descending)
    uasort($results, function($a, $b) {
        return $b['probability'] <=> $a['probability'];
    });
    
    return $results;
}

/**
 * Get recommendation based on diagnosis results
 */
function getRecommendation($results, $diseaseInfo, $lang) {
    $primaryDisease = key($results);
    $primaryResult = reset($results);
    
    $recommendations = [
        'en' => [
            'high' => [
                'message' => "Based on your symptoms, there is a high probability of " . $diseaseInfo[$primaryDisease]['name'] . ". We recommend consulting a healthcare professional for confirmation and treatment.",
                'suggestion' => "Consider booking an appointment with a doctor specializing in infectious diseases."
            ],
            'moderate' => [
                'message' => "Your symptoms suggest a moderate possibility of " . $diseaseInfo[$primaryDisease]['name'] . ". Monitoring your condition is advised, and you should consult a doctor if symptoms persist or worsen.",
                'suggestion' => "You may want to schedule a check-up within the next few days."
            ],
            'low' => [
                'message' => "Your symptoms indicate a low probability of the diseases we screened for. However, if you're experiencing discomfort, consulting a healthcare professional is always recommended.",
                'suggestion' => "Continue to monitor your symptoms and maintain good health practices."
            ]
        ],
        'af' => [
            'high' => [
                'message' => "Gebaseer op jou simptome, is daar \'n hoë waarskynlikheid van " . $diseaseInfo[$primaryDisease]['name'] . ". Ons beveel aan om \'n gesondheidsorgpraktisyn te raadpleeg vir bevestiging en behandeling.",
                'suggestion' => "Oorweeg om \'n afspraak te maak met \'n dokter wat spesialiseer in aansteeklike siektes."
            ],
            'moderate' => [
                'message' => "Jou simptome dui op \'n matige moontlikheid van " . $diseaseInfo[$primaryDisease]['name'] . ". Monitering van jou toestand word aanbeveel, en jy moet \'n dokter raadpleeg as simptome aanhou of vererger.",
                'suggestion' => "Jy mag dalk \'n kontrole-afspraak binne die volgende paar dae wil maak."
            ],
            'low' => [
                'message' => "Jou simptome dui op \'n lae waarskynlikheid van die siektes waarvoor ons gesoek het. As jy egter ongemak ervaar, is dit altyd aanbeveel om \'n gesondheidsorgpraktisyn te raadpleeg.",
                'suggestion' => "Gaan voort om jou simptome te monitor en handhaaf goeie gesondheidspraktyke."
            ]
        ],
        'hz' => [
            'high' => [
                'message' => "Motjirongo womatjato mowako, oku na okuṱaṱa kombiṱi ko " . $diseaseInfo[$primaryDisease]['name'] . ". Twa ṱunakanḓa okukondja nomundangi wouṱiki wokuṱaṱa noukuḓukisa.",
                'suggestion' => "Ṱunakanḓa okubookera ondjendo nomundangi wovandu voḓoroka."
            ],
            'moderate' => [
                'message' => "Omatjato mowako ma ṱunakanḓa okuṱaṱa kwomatjangero ko " . $diseaseInfo[$primaryDisease]['name'] . ". Okuṱaṱa kwovandu vyowako kwa ṱunakanḓa, na wa kondja nomundangi tji omatjato ma ṱa okurora.",
                'suggestion' => "Wa ṱa okubookera ondjendo momatjangero mambura."
            ],
            'low' => [
                'message' => "Omatjato mowako ma ṱunakanḓa okuṱaṱa kotuke kovandu mbya twa ṱaṱa. Nungwari tji wa ṱunakanḓa okuṱaṱa, oku ṱunakanḓa okukondja nomundangi.",
                'suggestion' => "Rukama okuṱaṱa kwomatjato mowako na ṱunakanḓa okuyogora."
            ]
        ],
        'ng' => [
            'high' => [
                'message' => "Moshiponga shi sho wa li nashi, oku na okukala kombiṱi ko " . $diseaseInfo[$primaryDisease]['name'] . ". Twa indila okukongela konganga wokukwatathana nokuyandja.",
                'suggestion' => "Indila okubooka omutumba nogonganga wovandu vokufa."
            ],
            'moderate' => [
                'message' => "Oshiponga shi sho wa li nashi shi shika sha kwatathana ko " . $diseaseInfo[$primaryDisease]['name'] . ". Okukwatathana koshiponga shi sho wa li nashi sha indilwa, na wa kongela konganga tshi oshiponga shi shi thikama.",
                'suggestion' => "Wa indila okubooka omutumba momasiku mambura."
            ],
            'low' => [
                'message' => "Oshiponga shi sho wa li nashi shi shika sha kwatathana kotuke kovandu mwa twa hokolola. Nungwari tshi wa li nokukwatathana, oku indilwa okukongela konganga.",
                'suggestion' => "Thikama okukwatathana koshiponga shi sho wa li nashi na shilikifa okuyogora."
            ]
        ]
    ];
    
    if ($primaryResult['normalized_score'] >= 60) {
        return [
            'level' => 'high',
            'message' => $recommendations[$lang]['high']['message'],
            'suggestion' => $recommendations[$lang]['high']['suggestion']
        ];
    } elseif ($primaryResult['normalized_score'] >= 30) {
        return [
            'level' => 'moderate',
            'message' => $recommendations[$lang]['moderate']['message'],
            'suggestion' => $recommendations[$lang]['moderate']['suggestion']
        ];
    } else {
        return [
            'level' => 'low',
            'message' => $recommendations[$lang]['low']['message'],
            'suggestion' => $recommendations[$lang]['low']['suggestion']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $t['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
            --warning: #f39c12;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .navbar {
            background-color: var(--primary);
        }
        
        .navbar-brand {
            font-weight: 700;
        }
        
        .language-selector {
            margin-right: 15px;
        }
        
        .language-dropdown .dropdown-menu {
            min-width: 150px;
        }
        
        .language-flag {
            margin-right: 8px;
        }
        
        .symptom-checkbox {
            margin: 8px 0;
        }
        
        .diagnosis-result {
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .symptom-category {
            background-color: #f8f9fa;
            border-left: 4px solid var(--secondary);
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .progress {
            height: 25px;
            margin-bottom: 10px;
        }
        
        .disease-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
            margin-bottom: 20px;
        }
        
        .disease-card:hover {
            transform: translateY(-5px);
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 30px 0;
            margin-top: 40px;
        }
        
        .recommendation-box {
            border-left: 4px solid var(--secondary);
            background-color: #e8f4fc;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .high-risk {
            border-left-color: var(--accent);
            background-color: #fde8e8;
        }
        
        .moderate-risk {
            border-left-color: var(--warning);
            background-color: #fef5e8;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="logo-placeholder">
                    <img src="images/Logo.jpeg" alt="MESMTF Logo" class="nav-logo">
                </div>
                MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><?php echo $t['home']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php"><?php echo $t['about']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php"><?php echo $t['services']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="diagnosis.php"><?php echo $t['diagnosis']; ?></a>
                    </li>
                    <li class="nav-item language-selector">
                        <div class="dropdown language-dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <span class="language-flag"><?php echo $languages[$lang]['flag']; ?></span>
                                <?php echo $languages[$lang]['name']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <?php foreach ($languages as $code => $language): ?>
                                    <li>
                                        <a class="dropdown-item <?php echo $code == $lang ? 'active' : ''; ?>" href="?lang=<?php echo $code; ?>">
                                            <span class="language-flag"><?php echo $language['flag']; ?></span>
                                            <?php echo $language['name']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" data-bs-toggle="modal" data-bs-target="#loginModal"><?php echo $t['login']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php" data-bs-toggle="modal" data-bs-target="#registerModal"><?php echo $t['register']; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Diagnosis Section -->
    <section id="diagnosis" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold"><?php echo $t['diagnosis_title']; ?></h2>
                    <p class="lead"><?php echo $t['diagnosis_subtitle']; ?></p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-diagnoses me-2"></i> <?php echo $t['symptom_checker']; ?></h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted"><?php echo $t['symptom_instruction']; ?></p>
                            
                            <form method="POST" action="diagnosis.php">
                                <!-- Malaria Symptoms -->
                                <div class="symptom-category">
                                    <h5 class="mb-3"><?php echo $t['malaria_symptoms']; ?></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><?php echo $t['very_strong']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="abdominal_pain" id="m_abdominal_pain" <?php if(isset($_POST['symptoms']) && in_array('abdominal_pain', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_abdominal_pain"><?php echo $lang == 'en' ? 'Abdominal pain' : ($lang == 'af' ? 'Buikpyn' : ($lang == 'hz' ? 'Okuṱaṱa kombunda' : 'Okukwatathana kombunda')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="vomiting" id="m_vomiting" <?php if(isset($_POST['symptoms']) && in_array('vomiting', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_vomiting"><?php echo $lang == 'en' ? 'Vomiting' : ($lang == 'af' ? 'Braking' : ($lang == 'hz' ? 'Okuruka' : 'Okuruka')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="sore_throat" id="m_sore_throat" <?php if(isset($_POST['symptoms']) && in_array('sore_throat', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_sore_throat"><?php echo $lang == 'en' ? 'Sore throat' : ($lang == 'af' ? 'Seer keel' : ($lang == 'hz' ? 'Omuromo mbiṱi' : 'Omutwe gwa thikama')); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><?php echo $t['strong']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="headache" id="m_headache" <?php if(isset($_POST['symptoms']) && in_array('headache', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_headache"><?php echo $lang == 'en' ? 'Headache' : ($lang == 'af' ? 'Hoofpyn' : ($lang == 'hz' ? 'Omutwe mbiṱi' : 'Omutwe gwa thikama')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="fatigue" id="m_fatigue" <?php if(isset($_POST['symptoms']) && in_array('fatigue', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_fatigue"><?php echo $lang == 'en' ? 'Fatigue' : ($lang == 'af' ? 'Uitputting' : ($lang == 'hz' ? 'Okukatja' : 'Okukatja')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="cough" id="m_cough" <?php if(isset($_POST['symptoms']) && in_array('cough', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_cough"><?php echo $lang == 'en' ? 'Cough' : ($lang == 'af' ? 'Hoes' : ($lang == 'hz' ? 'Okukohora' : 'Okukohora')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="constipation" id="m_constipation" <?php if(isset($_POST['symptoms']) && in_array('constipation', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_constipation"><?php echo $lang == 'en' ? 'Constipation' : ($lang == 'af' ? 'Hardlywigheid' : ($lang == 'hz' ? 'Okuṱaṱa kwombunda' : 'Okukwatathana kombunda')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6><?php echo $t['weak']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="chest_pain" id="m_chest_pain" <?php if(isset($_POST['symptoms']) && in_array('chest_pain', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_chest_pain"><?php echo $lang == 'en' ? 'Chest pain' : ($lang == 'af' ? 'Borspyn' : ($lang == 'hz' ? 'Okuṱaṱa kombunda' : 'Okukwatathana kombunda')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="back_pain" id="m_back_pain" <?php if(isset($_POST['symptoms']) && in_array('back_pain', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_back_pain"><?php echo $lang == 'en' ? 'Back pain' : ($lang == 'af' ? 'Rugpyn' : ($lang == 'hz' ? 'Okuṱaṱa kombunda' : 'Okukwatathana kombunda')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="muscle_pain" id="m_muscle_pain" <?php if(isset($_POST['symptoms']) && in_array('muscle_pain', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_muscle_pain"><?php echo $lang == 'en' ? 'Muscle pain' : ($lang == 'af' ? 'Spierpyn' : ($lang == 'hz' ? 'Okuṱaṱa kwomitwe' : 'Okukwatathana kwomitwe')); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><?php echo $t['very_weak']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="diarrhea" id="m_diarrhea" <?php if(isset($_POST['symptoms']) && in_array('diarrhea', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_diarrhea"><?php echo $lang == 'en' ? 'Diarrhea' : ($lang == 'af' ? 'Diarrée' : ($lang == 'hz' ? 'Okuruka' : 'Okuruka')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="sweating" id="m_sweating" <?php if(isset($_POST['symptoms']) && in_array('sweating', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_sweating"><?php echo $lang == 'en' ? 'Sweating' : ($lang == 'af' ? 'Sweet' : ($lang == 'hz' ? 'Okutja omeya' : 'Okutja omeya')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="rash" id="m_rash" <?php if(isset($_POST['symptoms']) && in_array('rash', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_rash"><?php echo $lang == 'en' ? 'Rash' : ($lang == 'af' ? 'Uitslag' : ($lang == 'hz' ? 'Ombari' : 'Ombari')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="loss_of_appetite" id="m_loss_of_appetite" <?php if(isset($_POST['symptoms']) && in_array('loss_of_appetite', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="m_loss_of_appetite"><?php echo $lang == 'en' ? 'Loss of appetite' : ($lang == 'af' ? 'Verlies van eetlus' : ($lang == 'hz' ? 'Okukatja okurya' : 'Okukatja okulya')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Typhoid Symptoms -->
                                <div class="symptom-category mt-4">
                                    <h5 class="mb-3"><?php echo $t['typhoid_symptoms']; ?></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><?php echo $t['very_strong']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="abdominal_pain" id="t_abdominal_pain" <?php if(isset($_POST['symptoms']) && in_array('abdominal_pain', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_abdominal_pain"><?php echo $lang == 'en' ? 'Abdominal pain' : ($lang == 'af' ? 'Buikpyn' : ($lang == 'hz' ? 'Okuṱaṱa kombunda' : 'Okukwatathana kombunda')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="stomach_issues" id="t_stomach_issues" <?php if(isset($_POST['symptoms']) && in_array('stomach_issues', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_stomach_issues"><?php echo $lang == 'en' ? 'Stomach issues' : ($lang == 'af' ? 'Maagprobleme' : ($lang == 'hz' ? 'Omatjato kombunda' : 'Oshiponga shombunda')); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><?php echo $t['strong']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="headache" id="t_headache" <?php if(isset($_POST['symptoms']) && in_array('headache', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_headache"><?php echo $lang == 'en' ? 'Headache' : ($lang == 'af' ? 'Hoofpyn' : ($lang == 'hz' ? 'Omutwe mbiṱi' : 'Omutwe gwa thikama')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="persistent_fever" id="t_persistent_fever" <?php if(isset($_POST['symptoms']) && in_array('persistent_fever', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_persistent_fever"><?php echo $lang == 'en' ? 'Persistent high fever' : ($lang == 'af' ? 'Aanhoudende hoë koors' : ($lang == 'hz' ? 'Ombura mbiṱi' : 'Omutenya gwa thikama')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6><?php echo $t['weak']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="weakness" id="t_weakness" <?php if(isset($_POST['symptoms']) && in_array('weakness', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_weakness"><?php echo $lang == 'en' ? 'Weakness' : ($lang == 'af' ? 'Swakheid' : ($lang == 'hz' ? 'Okukatja' : 'Okukatja')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="tiredness" id="t_tiredness" <?php if(isset($_POST['symptoms']) && in_array('tiredness', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_tiredness"><?php echo $lang == 'en' ? 'Tiredness' : ($lang == 'af' ? 'Moegheid' : ($lang == 'hz' ? 'Okukatja' : 'Okukatja')); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><?php echo $t['very_weak']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="rash" id="t_rash" <?php if(isset($_POST['symptoms']) && in_array('rash', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_rash"><?php echo $lang == 'en' ? 'Rash' : ($lang == 'af' ? 'Uitslag' : ($lang == 'hz' ? 'Ombari' : 'Ombari')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="loss_of_appetite" id="t_loss_of_appetite" <?php if(isset($_POST['symptoms']) && in_array('loss_of_appetite', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="t_loss_of_appetite"><?php echo $lang == 'en' ? 'Loss of appetite' : ($lang == 'af' ? 'Verlies van eetlus' : ($lang == 'hz' ? 'Okukatja okurya' : 'Okukatja okulya')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Other Diseases (Expandable Framework) -->
                                <div class="symptom-category mt-4">
                                    <h5 class="mb-3"><?php echo $t['other_diseases']; ?></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><?php echo $t['tuberculosis']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="persistent_cough" id="tb_persistent_cough" <?php if(isset($_POST['symptoms']) && in_array('persistent_cough', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="tb_persistent_cough"><?php echo $lang == 'en' ? 'Persistent cough' : ($lang == 'af' ? 'Aanhoudende hoes' : ($lang == 'hz' ? 'Okukohora mbiṱi' : 'Okukohora gwa thikama')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="coughing_blood" id="tb_coughing_blood" <?php if(isset($_POST['symptoms']) && in_array('coughing_blood', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="tb_coughing_blood"><?php echo $lang == 'en' ? 'Coughing blood' : ($lang == 'af' ? 'Bloed ophoes' : ($lang == 'hz' ? 'Okukohora ombanda' : 'Okukohora ombanda')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="chest_pain" id="tb_chest_pain" <?php if(isset($_POST['symptoms']) && in_array('chest_pain', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="tb_chest_pain"><?php echo $lang == 'en' ? 'Chest pain' : ($lang == 'af' ? 'Borspyn' : ($lang == 'hz' ? 'Okuṱaṱa kombunda' : 'Okukwatathana kombunda')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="night_sweats" id="tb_night_sweats" <?php if(isset($_POST['symptoms']) && in_array('night_sweats', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="tb_night_sweats"><?php echo $lang == 'en' ? 'Night sweats' : ($lang == 'af' ? 'Nagswete' : ($lang == 'hz' ? 'Okutja omeya mourongo' : 'Okutja omeya mourongo')); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><?php echo $t['general_symptoms']; ?></h6>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="fever" id="gen_fever" <?php if(isset($_POST['symptoms']) && in_array('fever', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="gen_fever"><?php echo $lang == 'en' ? 'Fever' : ($lang == 'af' ? 'Koors' : ($lang == 'hz' ? 'Ombura' : 'Omutenya')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="weight_loss" id="gen_weight_loss" <?php if(isset($_POST['symptoms']) && in_array('weight_loss', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="gen_weight_loss"><?php echo $lang == 'en' ? 'Weight loss' : ($lang == 'af' ? 'Gewigsverlies' : ($lang == 'hz' ? 'Okukatja ouvite' : 'Okukatja ouvite')); ?></label>
                                            </div>
                                            <div class="form-check symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" value="fatigue" id="gen_fatigue" <?php if(isset($_POST['symptoms']) && in_array('fatigue', $_POST['symptoms'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="gen_fatigue"><?php echo $lang == 'en' ? 'Fatigue' : ($lang == 'af' ? 'Uitputting' : ($lang == 'hz' ? 'Okukatja' : 'Okukatja')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-stethoscope me-2"></i> <?php echo $t['analyze_symptoms']; ?>
                                    </button>
                                </div>
                            </form>
                            
                            <?php if ($diagnosisResult): ?>
                            <div id="diagnosisResult" class="diagnosis-result alert alert-info mt-4">
                                <h5><i class="fas fa-info-circle me-2"></i> <?php echo $t['preliminary_diagnosis']; ?></h5>
                                
                                <?php
                                $recommendation = getRecommendation($diagnosisResult, $diseaseInfo, $lang);
                                $riskClass = $recommendation['level'] == 'high' ? 'high-risk' : ($recommendation['level'] == 'moderate' ? 'moderate-risk' : '');
                                ?>
                                
                                <div class="recommendation-box <?php echo $riskClass; ?>">
                                    <p><strong><?php echo $t['assessment']; ?>:</strong> <?php echo $recommendation['message']; ?></p>
                                    <p><strong><?php echo $t['suggestion']; ?>:</strong> <?php echo $recommendation['suggestion']; ?></p>
                                </div>
                                
                                <h6 class="mt-4"><?php echo $t['detailed_results']; ?>:</h6>
                                <?php foreach ($diagnosisResult as $disease => $result): ?>
                                    <?php if ($result['normalized_score'] > 0): ?>
                                    <div class="disease-card card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $diseaseInfo[$disease]['name']; ?></h5>
                                            <p class="card-text"><?php echo $diseaseInfo[$disease]['description']; ?></p>
                                            
                                            <div class="mb-3">
                                                <label><?php echo $t['probability']; ?>: <?php echo number_format($result['probability'], 1); ?>%</label>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $result['probability']; ?>%;" 
                                                         aria-valuenow="<?php echo $result['probability']; ?>" aria-valuemin="0" aria-valuemax="100">
                                                        <?php echo number_format($result['probability'], 1); ?>%
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6><?php echo $t['treatment']; ?>:</h6>
                                                    <p><?php echo $diseaseInfo[$disease]['treatment']; ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6><?php echo $t['prevention']; ?>:</h6>
                                                    <p><?php echo $diseaseInfo[$disease]['prevention']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                
                                <div class="mt-3">
                                    <a href="appointment.php" class="btn btn-success">
                                        <i class="fas fa-calendar-check me-2"></i> <?php echo $t['book_appointment']; ?>
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='diagnosis.php'">
                                        <i class="fas fa-redo me-2"></i> <?php echo $t['new_diagnosis']; ?>
                                    </button>
                                </div>
                                
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong><?php echo $t['disclaimer']; ?>:</strong> <?php echo $t['disclaimer_text']; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
       <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">
                        <div class="logo-placeholder">
    <!-- logo Section -->
                            <img src="images\Logo.jpeg" alt="MESMTF Logo" class="footer-logo-img">
                        </div>
                        <div>
                            <h5 class="footer-heading">MESMTF System</h5>
                            <p>Medical Expert System for Malaria and Typhoid Fever - A comprehensive e-Health solution.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php" class="footer-link">Home</a></li>
                        <li><a href="about.php" class="footer-link">About</a></li>
                        <li><a href="services.php" class="footer-link">Services</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Contact Us</h5>
                    <div class="contact-info">
                        <p><span class="contact-icon"></span> 13 Jackson Kaijieua Street<br>Private Bag 1388, Winbrook, NAMIBIA</p>
                        <p><span class="contact-icon"></span> +264 61 207 2052</p>
                        <p><span class="contact-icon"></span> tfse@nust.na</p>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; 2025 MESMTF. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Developed for Ministry of Health and Social Services</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navigation menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Get the current page filename
            const currentPage = location.pathname.split('/').pop();
            // Remove active class from all nav items
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            // Add active class to the current page's nav item
            if (currentPage === 'index.php' || currentPage === '') {
                document.querySelector('a[href="index.php"]').classList.add('active');
            } else if (currentPage === 'services.php') {
                document.querySelector('a[href="services.php"]').classList.add('active');
            } else if (currentPage === 'about.php') {
                document.querySelector('a[href="about.php"]').classList.add('active');
            } else if (currentPage === 'diagnosis.php') {
                document.querySelector('a[href="diagnosis.php"]').classList.add('active');
            }
        });
    </script>
</body>
</html>