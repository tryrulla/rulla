<?php


namespace Rulla\Meta;


trait HasViewUrl
{
    use HasFormattedIdentifier;

    public function initializeHasViewUrl()
    {
        $this->append('viewUrl');
    }

    public function getViewUrlAttribute()
    {
        return url('app/view/' . $this->getIdentifierAttribute());
    }
}
