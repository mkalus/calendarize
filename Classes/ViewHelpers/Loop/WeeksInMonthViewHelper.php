<?php
/**
 * Weeks in month view helper
 *
 * @author  Tim Lochmüller
 */

namespace HDNET\Calendarize\ViewHelpers\Loop;

use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Weeks in month view helper
 *
 * @author Tim Lochmüller
 */
class WeeksInMonthViewHelper extends AbstractLoopViewHelper
{

    /**
     * The week start at
     *
     * @var int
     */
    protected $weekStartsAt;

    /**
     * Render the element
     *
     * @param \DateTime $date
     * @param string    $iteration
     * @param int       $weekStartsAt
     *
     * @return string
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function render(\DateTime $date, $iteration, $weekStartsAt)
    {
        $this->weekStartsAt = MathUtility::forceIntegerInRange((int)$weekStartsAt, 1, 7, 1);
        return parent::render($date, $iteration);
    }

    /**
     * Get the items
     *
     * @param \DateTime $date
     *
     * @return array
     */
    protected function getItems(\DateTime $date)
    {
        $weeks = [];
        $date->setDate($date->format('Y'), $date->format('n'), 1);
        $monthCheck = $date->format('m');
        while ((int)$monthCheck == (int)$date->format('m')) {
            $week = (int)$date->format('W');
            if (!isset($weeks[$week])) {
                $weeks[$week] = [
                    'week' => $week,
                    'date' => clone $date,
                ];
            }
            $date->modify('+1 day');
        }
        return $weeks;
    }
}
