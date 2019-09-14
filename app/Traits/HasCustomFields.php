<?php

namespace Rulla\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rulla\Items\Fields\FieldValue;

trait HasCustomFields
{
    public function fields()
    {
        return $this->morphMany(FieldValue::class, 'value_holder');
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function processFieldUpdate(Request $request) {
        if ($request->has('custom-fields')) {
            $data = collect(json_decode($request->get('custom-fields')));

            $fieldIds = $data->map(function ($it) {
                return $it->field_id;
            });

            $selfId = $this->id;

            try {
                DB::beginTransaction();

                FieldValue::where('value_holder_id', $selfId)
                    ->where('value_holder_type', get_class($this))
                    ->whereNotIn('field_id', $fieldIds)
                    ->delete();

                $data->each(function ($it) use ($selfId) {
                    FieldValue::updateOrCreate([
                        'value_holder_id' => $selfId,
                        'value_holder_type' => get_class($this),
                        'field_id' => $it->field_id,
                    ], [
                        'value' => $it->value,
                    ]);
                });

                DB::commit();
            } catch (Exception $ex) {
                DB::rollback();
                throw $ex;
            }
        }
    }

}
