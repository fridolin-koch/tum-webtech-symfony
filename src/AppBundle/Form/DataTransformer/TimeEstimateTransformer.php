<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class TimeEstimateTransformer
 *
 * @author Fridolin Koch <info@fridokoch.de>
 */
class TimeEstimateTransformer implements DataTransformerInterface
{
    /**
     * Transform the time estimate from seconds to a more common format. E.g.: 3h30 => 3 hours and 30 minutes
     *
     * @param int $value The value in the original representation
     *
     * @return string The value in the transformed representation
     */
    public function transform($value)
    {
        if ($value === null) {
            return '';
        }
        //transform seconds to simpler format: {hours}h{minutes}
        $hours = $minutes = 0;
        if ($value >= 3600) {
            $hours = floor($value/3600);
            $value = $value%3600;
        }
        $minutes = floor($value/60);

        return $hours.'h'.$minutes;
    }

    /**
     * Transform a string line 1h30 into seconds.
     *
     * @param string $value The value in the transformed representation
     *
     * @return int The value in the original representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function reverseTransform($value)
    {
        /** @var \AppBundle\Entity\Task $value */
        if ($value === null) {
            return '';
        }
        if (preg_match('/\d+h\d+$/u', $value) === 0) {
            throw new TransformationFailedException('Format: {hours}h{minutes}, example: 2h30');
        }
        $time = explode('h', $value);

        return intval($time[0])*3600 + intval($time[1])*60;
    }
}
