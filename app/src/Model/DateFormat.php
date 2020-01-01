<?php

namespace RecruitingApp\Model;

trait DateFormat
{
    /**
     * @param \DateTime $dateTime
     *
     * @return string
     */
    public function formatDateView(\DateTime $dateTime)
    {
        return $dateTime->format(getenv('date_view'));
    }
}