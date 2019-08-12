<?php

namespace Rulla\Meta;

trait HasFormattedIdentifier
{
    abstract public function getIdentifierPrefixLetter(): string;

    public function initializeHasFormattedIdentifier()
    {
        $this->append('identifier');
    }

    public function getIdentifierAttribute()
    {
        return $this->getIdentifierPrefixLetter() . str_pad($this->id, 7, '0', STR_PAD_LEFT);
    }
}
