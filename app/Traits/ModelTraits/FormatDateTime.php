<?php

namespace App\Traits\ModelTraits;

trait FormatDateTime
{
    /**
     * Get formatted date and time for created_at attribute.
     *
     * @param  string  $date
     */
    public function getFormatCreatedAtAttribute(): ?string
    {
        return $this->getDateAndTime('created_at');
    }

    /**
     * Get formatted date only for created_at attribute.
     *
     * @param  string  $date
     */
    public function getFormatCreatedAtOnlyDateAttribute(): ?string
    {
        return $this->getDate('created_at');
    }

    /**
     * Get formatted time only for created_at attribute.
     *
     * @param  string  $date
     */
    public function getFormatCreatedAtOnlyTimeAttribute(): ?string
    {
        return $this->getTime('created_at');
    }

    /**
     * Get formatted date and time for updated_at attribute.
     *
     * @param  string  $date
     */
    public function getFormatUpdatedAtAttribute(): ?string
    {
        return $this->getDateAndTime('updated_at');
    }

    /**
     * Get formatted date only for updated_at attribute.
     *
     * @param  string  $date
     */
    public function getFormatUpdatedAtOnlyDateAttribute(): ?string
    {
        return $this->getDate('updated_at');
    }

    /**
     * Get formatted time only for updated_at attribute.
     *
     * @param  string  $date
     */
    public function getFormatUpdatedAtOnlyTimeAttribute(): ?string
    {
        return $this->getTime('updated_at');
    }

    /**
     * Format date and time.
     */
    protected function getDateAndTime(string $date): ?string
    {
        return $this->formatDateTime($this->attributes[$date]);
    }

    /**
     * Format date.
     */
    protected function getDate(string $date): ?string
    {
        return $this->formatDate($this->attributes[$date]);
    }

    /**
     * Format time.
     */
    protected function getTime(string $date): ?string
    {
        return $this->formatTime($this->attributes[$date]);
    }

    /**
     * Format date and time using helper functions.
     *
     * @param  mixed  $date
     */
    protected function formatDateTime($date): ?string
    {
        return timeZoneFormatDate($date) . ' ' . timeZoneGetTime($date);
    }

    /**
     * Format date using helper function.
     *
     * @param  mixed  $date
     */
    protected function formatDate($date): ?string
    {
        return timeZoneFormatDate($date);
    }

    /**
     * Format time using helper function.
     *
     * @param  mixed  $date
     */
    protected function formatTime($date): ?string
    {
        return timeZoneGetTime($date);
    }
}
