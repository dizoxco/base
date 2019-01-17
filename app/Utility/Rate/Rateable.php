<?php

namespace App\Utility\Rate;

use App\Models\Rate;
use App\Models\RateFormat;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Rateable
{
    private $namespace = 'App\\Utility\\Rate\\Methods\\';

    /**
     * set polymorphic relation to associated model
     * @return MorphMany
     */
    public function rates() : MorphMany
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    /**
     * @param object $request
     *
     * @return int
     * @throws Exception
     */
    public function updateRate($request)
    {
        $config = $this->getRateFormat();
        $format = $config->type;

        if (!class_exists($format)) {
            throw new Exception("$format not found.");
        }

        $rate = (
            new $format($config->toArray(), $request, $this->getRateResult(), $this->getRateData())
        )->calculate();

        $this->rate_data = json_encode($rate->getRateData());
        $this->rate_result = json_encode($rate->getRateResult());

        if ($result = $this->update()) {
            $this->rates()->create([
                'user_id' => $request->get('user_id'),
                'rate_detail' => json_encode(['type'])
            ]);
        }

        return $result;
    }

    /**
     * get model rate result
     *
     * @return object | int | null
     */
    private function getRateResult()
    {
        return json_decode($this->rate_result);
    }

    /**
     * get model rate data
     *
     * @return object | null
     */
    private function getRateData()
    {
        return json_decode($this->rate_data);
    }

    /**
     * each model must have it's own implementation
     *
     * @return RateFormat
     */
    abstract public function getRateFormat(): RateFormat;
}