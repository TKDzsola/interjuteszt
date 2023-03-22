<?php
function calculatePoints($applicant) {
  // Check if applicant has taken mandatory exams
  if (!isset($applicant['magyar']) || !isset($applicant['tortenelem']) || !isset($applicant['matematika'])) {
    return "Pontszámítás nem lehetséges, mert a kötelező tantárgyak közül valamelyik hiányzik.";
  }

  // Check if applicant has taken at least one elective exam
  if (!isset($applicant['biologia']) && !isset($applicant['fizika']) && !isset($applicant['informatika']) && !isset($applicant['kemia'])) {
    return "Pontszámítás nem lehetséges, mert nincs választott tárgy.";
  }

  // Check if any exam has less than 20% score
  foreach ($applicant as $exam => $score) {
    if ($exam != 'nyelv' && $score < 20) {
      return "Pontszámítás nem lehetséges, mert az alábbi tantárgyból elégtelen eredményt ért el: " . $exam;hh
    }
  }

  // Calculate base points
  $base_points = 2 * ($applicant['magyar'] + max($applicant['biologia'], $applicant['fizika'], $applicant['informatika'], $applicant['kemia']));

  // Calculate additional points
  $additional_points = 0;
  if (isset($applicant['nyelv'])) {
    if ($applicant['nyelv'] >= 'B2') {
      $additional_points += 28;
    }
    if ($applicant['nyelv'] >= 'C1') {
      $additional_points += 40;
    }
  }
  if (isset($applicant['emelt_matek'])) {
    $additional_points += 50;
  }
  if (isset($applicant['emelt_biologia'])) {
    $additional_points += 50;
  }
  if (isset($applicant['emelt_fizika'])) {
    $additional_points += 50;
  }
  if (isset($applicant['emelt_informatika'])) {
    $additional_points += 50;
  }
  if (isset($applicant['emelt_kemia'])) {
    $additional_points += 50;
  }

  // Calculate total points
  $total_points = $base_points + min($additional_points, 100);

  return $total_points;
}

?>