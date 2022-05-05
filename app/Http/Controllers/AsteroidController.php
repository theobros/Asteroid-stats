<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsteroidRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\throwException;

class AsteroidController extends Controller
{
    /**
     * get stats from nasa api endpoint
     *
     * @param AsteroidRequest $request
     * @return array of values
     */
    public function getStats(AsteroidRequest $request)
    {

        $url = "https://api.nasa.gov/neo/rest/v1/feed?start_date=$request->start_date&end_date=$request->end_date&detailed=true&api_key=" . config('app.nasa_api_key');

        $chart_data = $fastest_asteroid = $closest_asteroid = array();
        $average_size_of_asteroids  = 0;
        try {
            $response = Http::get($url);

            if ($response->status() == 200) {
                $result = json_decode($response->body(), true);
                $speed_data = $distance_data = array();
                $total_size = $total_asteroids_count = 0;

                foreach ($result['near_earth_objects'] as $key => $asteroids) {

                    $count = count($asteroids);
                    $chart_data[$key] = $count;
                    $total_asteroids_count = $total_asteroids_count + $count;

                    foreach ($asteroids as  $asteroid) {

                        $speed_data[$asteroid['id']] = $asteroid['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'];

                        $distance_data[$asteroid['id']] = $asteroid['close_approach_data'][0]['miss_distance']['kilometers'];

                        $total_size = $total_size + $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max'];
                    }
                }

                //Fastest Asteroid in km/h (Respective Asteroid ID & its speed)
                asort($speed_data);
                $fastest_asteroid = array_slice($speed_data, -1, 1, true);

                //Closest Asteroid (Respective Asteroid ID & its distance)
                asort($distance_data);
                $closest_asteroid = array_slice($distance_data, -1, 1, true);

                //Average Size of the Asteroids in kilometers
                $average_size_of_asteroids = round($total_size / $total_asteroids_count, 3);
            }
            return view('pages.chart', compact('chart_data', 'fastest_asteroid', 'closest_asteroid', 'average_size_of_asteroids'));
        } catch (\Exception $e) {
            return view('pages.landing')
                ->withErrors(['errors' => $e->getMessage()]);
        }
    }
}
