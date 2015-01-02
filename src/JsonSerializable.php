<?php
/*
 * This file is part of the Money package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Objects implementing JsonSerializable
 * can customize their JSON representation when encoded with
 * <b>json_encode</b>.
 * @link http://php.net/manual/en/class.jsonserializable.php
 */
interface JsonSerializable
{
    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * @link   http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize();
}
