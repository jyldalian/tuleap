<?php
/**
 * Copyright (c) Enalean, 2019 - present. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see http://www.gnu.org/licenses/.
 *
 */

declare(strict_types = 1);

namespace Tuleap\Docman\REST\v1\Metadata;

use Tuleap\REST\JsonCast;

class MetadataRepresentation
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $value;
    /**
     * @var array|null {@type Tuleap\Docman\REST\v1\Metadata\MetadataListValueRepresentation}
     */
    public $list_value;
    /**
     * @var bool
     */
    public $is_required;
    /**
     * @var bool
     */
    public $is_multiple_value_allowed;

    public function __construct(
        string $name,
        string $type,
        bool $is_multiple_value_allowed,
        string $value,
        ?array $list_value,
        bool $is_required
    ) {
        $this->name = $name;
        $this->type = $type;
        if ($type === PLUGIN_DOCMAN_METADATA_TYPE_DATE_LABEL && $value) {
            $this->value = JsonCast::toDate($value);
        } else {
            $this->value = $value;
        }
        $this->is_required               = $is_required;
        $this->is_multiple_value_allowed = $is_multiple_value_allowed;
        $this->list_value                = $list_value;
    }
}
