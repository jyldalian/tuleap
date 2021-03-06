<?php
/**
 * Copyright (c) Enalean, 2016 - 2018. All Rights Reserved.
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
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tuleap\PullRequest;

use Tuleap\Label\Labelable;

class PullRequest implements Labelable
{

    public const STATUS_ABANDONED = 'A';
    public const STATUS_MERGED    = 'M';
    public const STATUS_REVIEW    = 'R';

    public const UNKNOWN_MERGE        = 0;
    public const NO_FASTFORWARD_MERGE = 1;
    public const FASTFORWARD_MERGE    = 2;
    public const CONFLICT_MERGE       = 3;

    public const BUILD_STATUS_UNKNOWN = 'U';
    public const BUILD_STATUS_SUCCESS = 'S';
    public const BUILD_STATUS_FAIL    = 'F';

    private $id;
    private $title;
    private $description;
    private $repository_id;
    private $user_id;
    private $creation_date;
    private $branch_src;
    private $sha1_src;
    private $repo_dest_id;
    private $branch_dest;
    private $sha1_dest;
    private $status;
    private $merge_status;
    private $last_build_status;
    private $last_build_date;

    public function __construct(
        $id,
        $title,
        $description,
        $repository_id,
        $user_id,
        $creation_date,
        $branch_src,
        $sha1_src,
        $repo_dest_id,
        $branch_dest,
        $sha1_dest,
        $last_build_date = null,
        $last_build_status = self::BUILD_STATUS_UNKNOWN,
        $status = 'R',
        $merge_status = self::UNKNOWN_MERGE
    ) {
        $this->id                = $id;
        $this->title             = $title;
        $this->description       = $description;
        $this->repository_id     = $repository_id;
        $this->user_id           = $user_id;
        $this->creation_date     = $creation_date;
        $this->branch_src        = $branch_src;
        $this->sha1_src          = $sha1_src;
        $this->repo_dest_id      = $repo_dest_id;
        $this->branch_dest       = $branch_dest;
        $this->sha1_dest         = $sha1_dest;
        $this->last_build_date   = $last_build_date;
        $this->last_build_status = $last_build_status;
        $this->status            = $status;
        $this->merge_status      = $merge_status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getRepositoryId()
    {
        return $this->repository_id;
    }

    public function getBranchSrc()
    {
        return $this->branch_src;
    }

    public function getSha1Src()
    {
        return $this->sha1_src;
    }

    public function getRepoDestId()
    {
        return $this->repo_dest_id;
    }

    public function getBranchDest()
    {
        return $this->branch_dest;
    }

    public function getSha1Dest()
    {
        return $this->sha1_dest;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMergeStatus()
    {
        return $this->merge_status;
    }

    public function setMergeStatus($merge_status)
    {
        return $this->merge_status = $merge_status;
    }

    /**
     * @deprecated
     */
    public function getLastBuildDate()
    {
        return $this->last_build_date;
    }

    /**
     * @deprecated
     */
    public function getLastBuildStatus()
    {
        return $this->last_build_status;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @deprecated
     */
    public function setLastBuildStatus($status)
    {
        $this->last_build_status = $status;
    }

    /**
     * @deprecated
     */
    public function setLastBuildDate($date)
    {
        $this->last_build_date = $date;
    }
}
