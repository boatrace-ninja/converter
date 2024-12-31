<?php

declare(strict_types=1);

namespace Boatrace\Ninja;

use Carbon\CarbonImmutable as Carbon;

/**
 * @author shimomo
 */
class MainConverter
{
    /**
     * @var array
     */
    protected array $properties = [];

    /**
     * @return void
     */
    public function __construct()
    {
        foreach (glob(__DIR__ . '/../config/*.php') as $filename) {
            $this->properties[basename($filename, '.php')] = require $filename;
        }
    }

    /**
     * @param  string|null  $value
     * @return string|null
     */
    public function convertToString(?string $value): ?string
    {
        return is_null($value) ? null : Trimmer::trim(
            mb_convert_kana($value, 'as', 'utf-8')
        );
    }

    /**
     * @param  string|null  $value
     * @return int|null
     */
    public function convertToInt(?string $value): ?int
    {
        return is_null($value) ? null : (int) $this->convertToString($value);
    }

    /**
     * @param  string|null  $value
     * @return float|null
     */
    public function convertToFloat(?string $value): ?float
    {
        return is_null($value) ? null : (float) $this->convertToString($value);
    }

    /**
     * @param  string|null  $value
     * @return string|null
     */
    public function convertToName(?string $value): ?string
    {
        $pattern = '/[\\x0-\x20\x7f\xc2\xa0\xe3\x80\x80]++/u';
        $subject = $this->convertToString($value) ?? '';
        $array = preg_split($pattern, $subject, -1, PREG_SPLIT_NO_EMPTY) + [1 => ''];
        return is_null($value) ? null : implode(' ', $array);
    }

    /**
     * @param  string|null  $value
     * @return int|null
     */
    public function convertToFlying(?string $value): ?int
    {
        return $this->convertToInt(
            Trimmer::ltrim($this->convertToString($value), 'F')
        );
    }

    /**
     * @param  string|null  $value
     * @return int|null
     */
    public function convertToLate(?string $value): ?int
    {
        return $this->convertToInt(
            Trimmer::ltrim($this->convertToString($value), 'L')
        );
    }

    /**
     * @param  string|null  $value
     * @return float|null
     */
    public function convertToStartTiming(?string $value): ?float
    {
        return match (substr($value = $this->convertToString($value) ?? '', 0, 1)) {
            'F' => $this->convertToFloat('-1'),
            'L' => $this->convertToFloat('1'),
            default => $value === '' ? null : $this->convertToFloat(
                sprintf('%d%s', 0, preg_replace('/[^0-9.]/', '', $value))
            ),
        };
    }

    /**
     * @param  string|null  $value
     * @return int|null
     */
    public function convertToWind(?string $value): ?int
    {
        return $this->convertToInt(
            Trimmer::rtrim($this->convertToString($value), 'm')
        );
    }

    /**
     * @param  string|null  $value
     * @return int|null
     */
    public function convertToWindDirection(?string $value): ?int
    {
        $pattern = '/is-wind(\d+)/';
        $subject = $this->convertToString($value) ?? '';
        return preg_match($pattern, $subject, $matches) ? (int) $matches[1] : null;
    }

    /**
     * @param  string|null  $value
     * @return int|null
     */
    public function convertToWave(?string $value): ?int
    {
        return $this->convertToInt(
            Trimmer::rtrim($this->convertToString($value), 'cm')
        );
    }

    /**
     * @param  string|null  $value
     * @return float|null
     */
    public function convertToTemperature(?string $value): ?float
    {
        return $this->convertToFloat(
            Trimmer::rtrim($this->convertToString($value), '℃')
        );
    }

    /**
     * @param  string|null  $value
     * @return string|null
     */
    public function convertToDate(?string $value): ?string
    {
        return is_null($value) ? null : Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * @param  string|null  $value
     * @return string|null
     */
    public function convertToDateTime(?string $value): ?string
    {
        return is_null($value) ? null : Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * @param  string|null  $name
     * @return int|null
     */
    public function convertToClassId(?string $name): ?int
    {
        $name = $this->convertToString($name);
        $classes = array_column($this->properties['classes'], 'id', 'name');
        return $classes[$name] ?? null;
    }

    /**
     * @param  int|null  $id
     * @return string|null
     */
    public function convertToClassName(?int $id): ?string
    {
        $classes = array_column($this->properties['classes'], 'name', 'id');
        return $classes[$id] ?? null;
    }

    /**
     * @param  string|null  $name
     * @return int|null
     */
    public function convertToPlaceId(?string $name): ?int
    {
        $name = $this->convertToString($name);
        $places = array_column($this->properties['places'], 'id', 'name');
        return $places[$name] ?? null;
    }

    /**
     * @param  int|null  $id
     * @return string|null
     */
    public function convertToPlaceName(?int $id): ?string
    {
        $places = array_column($this->properties['places'], 'name', 'id');
        return $places[$id] ?? null;
    }

    /**
     * @param  string|null  $name
     * @return int|null
     */
    public function convertToPrefectureId(?string $name): ?int
    {
        $name = $this->convertToString($name);
        $prefectures = array_column($this->properties['prefectures'], 'id', 'name');
        return $prefectures[$name] ?? null;
    }

    /**
     * @param  int|null  $id
     * @return string|null
     */
    public function convertToPrefectureName(?int $id): ?string
    {
        $prefectures = array_column($this->properties['prefectures'], 'name', 'id');
        return $prefectures[$id] ?? null;
    }

    /**
     * @param  string|null  $name
     * @return int|null
     */
    public function convertToStadiumId(?string $name): ?int
    {
        $name = $this->convertToString($name);
        $stadiums = array_column($this->properties['stadiums'], 'id', 'name');
        return $stadiums[$name] ?? null;
    }

    /**
     * @param  int|null  $id
     * @return string|null
     */
    public function convertToStadiumName(?int $id): ?string
    {
        $stadiums = array_column($this->properties['stadiums'], 'name', 'id');
        return $stadiums[$id] ?? null;
    }

    /**
     * @param  string|null  $name
     * @return int|null
     */
    public function convertToTechniqueId(?string $name): ?int
    {
        $name = $this->convertToString($name);
        $techniques = array_column($this->properties['techniques'], 'id', 'name');
        return $techniques[$name] ?? null;
    }

    /**
     * @param  int|null  $id
     * @return string|null
     */
    public function convertToTechniqueName(?int $id): ?string
    {
        $techniques = array_column($this->properties['techniques'], 'name', 'id');
        return $techniques[$id] ?? null;
    }

    /**
     * @param  string|null  $name
     * @return int|null
     */
    public function convertToWeatherId(?string $name): ?int
    {
        $name = $this->convertToString($name);
        $weathers = array_column($this->properties['weathers'], 'id', 'name');
        return $weathers[$name] ?? null;
    }

    /**
     * @param  int|null  $id
     * @return string|null
     */
    public function convertToWeatherName(?int $id): ?string
    {
        $weathers = array_column($this->properties['weathers'], 'name', 'id');
        return $weathers[$id] ?? null;
    }
}
