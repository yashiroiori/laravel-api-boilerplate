<?php

namespace App\Http\Requests;

use App\Models\WidgetPreset;

class UpdateWidgetPresetRequest extends ApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if ($this->isMethod('PATCH')) {
			return $this->filterWithModelConfiguration(WidgetPreset::class, WidgetPreset::getPatchRules());
		} elseif ($this->isMethod('PUT')) {
			return $this->filterWithModelConfiguration(WidgetPreset::class, WidgetPreset::getPutRules());
		} else {
			// @fixme Api documentation generator method "GET" for update... return PUT method rules
			return $this->filterWithModelConfiguration(WidgetPreset::class, WidgetPreset::getPutRules());
		}
	}
}