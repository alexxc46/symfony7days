<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateTimeZone;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="app_form")
     */
    public function getFormData(Request $request, ValidatorInterface $validator): Response
    {
        $result = null;
        $errors = [];

        if ($request->isMethod('POST')) {
            $date = $request->request->get('date');
            $timezone = $request->request->get('timezone');

            $dateErrors = $validator->validate($date, [
                new Assert\Regex([
                    'pattern' => '/^\d{4}-\d{2}-\d{2}$/',
                    'message' => 'The date should be in the format YYYY-MM-DD.',
                ]),
                new Assert\Date(),
            ]);

            $timezoneErrors = $validator->validate($timezone, [
                new Assert\Regex([
                    'pattern' => '/^[\w\/]+$/',
                    'message' => 'Invalid timezone format.',
                ]),
                new Assert\Choice([
                    'choices' => DateTimeZone::listIdentifiers(),
                    'message' => 'The timezone "{{ value }}" is not valid.',
                ]),
            ]);

            if (count($dateErrors) === 0 && count($timezoneErrors) === 0) {
                $result = $this->processForm($date, $timezone);
            } else {
                $errors = array_merge(
                    iterator_to_array($dateErrors),
                    iterator_to_array($timezoneErrors)
                );
            }
        }

        return $this->render('form/form.html.twig', [
            'result' => $result,
            'errors' => $errors,
        ]);
    }

    private function processForm($date, $timezone): array
    {
        $dateTime = new DateTime($date . ' 12:00:00', new DateTimeZone($timezone));
        $offset = $dateTime->getOffset() / 60;

        $year = (int) $dateTime->format('Y');
        $month = (int) $dateTime->format('m');
        $daysInFebruary = $this->daysInFebruary($year);
        $daysInMonth = $this->daysInMonth($year, $month);
        $monthName = $dateTime->format('F');

        return [
            'timezone' => $timezone,
            'offset' => $offset,
            'daysInFebruary' => $daysInFebruary,
            'monthName' => $monthName,
            'daysInMonth' => $daysInMonth,
        ];
    }

    private function daysInFebruary($year): int
    {
        return (date('L', strtotime("$year-02-01"))) ? 29 : 28;
    }

    private function daysInMonth($year, $month): int
    {
        return (new DateTime("$year-$month-01"))->format('t');
    }
}