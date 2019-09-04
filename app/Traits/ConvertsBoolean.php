<?php
namespace Rulla\Traits;

trait ConvertsBoolean
{
    // protected $boolean_attributes = [];

    /**
     * Override the FormRequest prepareForValidation() method to
     * add boolean attributes specified to the request data, setting
     * their value to the presence of the data in the original request.
     *
     * @return void
     */
    protected function prepareForValidation() {
        if (isset($this->boolean_attributes) && is_array($this->boolean_attributes)) {
            $attrs_to_add = [];

            foreach ($this->boolean_attributes as $attribute) {
                $attrs_to_add[$attribute] = $this->has($attribute);
            }

            $this->merge($attrs_to_add);
        }
    }
}
