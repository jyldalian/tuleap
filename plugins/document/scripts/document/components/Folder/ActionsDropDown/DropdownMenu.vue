<!--
  - Copyright (c) Enalean, 2019 - present. All Rights Reserved.
  -
  - This file is a part of Tuleap.
  -
  - Tuleap is free software; you can redistribute it and/or modify
  - it under the terms of the GNU General Public License as published by
  - the Free Software Foundation; either version 2 of the License, or
  - (at your option) any later version.
  -
  - Tuleap is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU General Public License for more details.
  -
  - You should have received a copy of the GNU General Public License
  - along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
  -->

<template>
    <div class="tlp-dropdown-menu document-dropdown-menu"
         v-bind:class="{
             'tlp-dropdown-menu-large tlp-dropdown-menu-top': isInFolderEmptyState,
             'tlp-dropdown-menu-right': isInQuickLookMode
         }"
         role="menu"
    >
        <slot></slot>
        <span v-if="! hideItemTitle" class="tlp-dropdown-menu-title document-dropdown-menu-title" role="menuitem">
            {{ item.title }}
        </span>
        <a v-if="! hideDetailsEntry"
           v-bind:href="getUrlForPane(DETAILS_PANE_NAME)"
           class="tlp-dropdown-menu-item"
           role="menuitem"
           data-test="docman-dropdown-details"
        >
            <i class="fa fa-fw fa-list tlp-dropdown-menu-item-icon"></i>
            <span v-translate>
                Details
            </span>
        </a>
        <a v-bind:href="getUrlForPane(NOTIFS_PANE_NAME)" class="tlp-dropdown-menu-item" role="menuitem">
            <i class="fa fa-fw fa-bell-o tlp-dropdown-menu-item-icon"></i>
            <span v-translate>
                Notifications
            </span>
        </a>
        <a v-bind:href="getUrlForPane(HISTORY_PANE_NAME)" class="tlp-dropdown-menu-item" role="menuitem">
            <i class="fa fa-fw fa-history tlp-dropdown-menu-item-icon"></i>
            <span v-translate>
                History
            </span>
        </a>
        <a v-if="item.can_user_manage"
           v-bind:href="getUrlForPane(PERMISSIONS_PANE_NAME)"
           class="tlp-dropdown-menu-item"
           role="menuitem"
           data-test="docman-dropdown-permissions"
        >
            <i class="fa fa-fw fa-lock tlp-dropdown-menu-item-icon"></i>
            <span v-translate>
                Permissions
            </span>
        </a>
        <a v-if="! is_item_type_empty"
           v-bind:href="getUrlForPane(APPROVAL_TABLES_PANE_NAME)"
           class="tlp-dropdown-menu-item"
           role="menuitem"
           data-test="docman-dropdown-approval-tables"
        >
            <i class="fa fa-fw fa-check-square-o tlp-dropdown-menu-item-icon"></i>
            <span v-translate>
                Approval tables
            </span>
        </a>
        <span class="tlp-dropdown-menu-separator" role="separator" v-if="item.user_can_write"></span>
        <a v-if="item.user_can_write"
           v-bind:href="delete_url"
           class="tlp-dropdown-menu-item tlp-dropdown-menu-item-danger"
           role="menuitem"
           data-test="docman-dropdown-delete"
        >
            <i class="fa fa-fw fa-trash-o tlp-dropdown-menu-item-icon"></i>
            <span v-translate> Delete </span>
        </a>
    </div>
</template>
<script>
import { mapState } from "vuex";
import { TYPE_EMPTY } from "../../../constants.js";

export default {
    name: "DropdownMenu",
    props: {
        isInFolderEmptyState: Boolean,
        isInQuickLookMode: Boolean,
        hideItemTitle: Boolean,
        hideDetailsEntry: Boolean,
        item: Object
    },
    data() {
        return {
            DETAILS_PANE_NAME: "details",
            NOTIFS_PANE_NAME: "notifications",
            HISTORY_PANE_NAME: "history",
            PERMISSIONS_PANE_NAME: "permissions",
            APPROVAL_TABLES_PANE_NAME: "approval"
        };
    },
    computed: {
        ...mapState(["project_id"]),
        is_item_type_empty() {
            return this.item.type === TYPE_EMPTY;
        },
        delete_url() {
            return `/plugins/docman/?group_id=${this.project_id}&action=confirmDelete&id=${
                this.item.id
            }`;
        }
    },
    methods: {
        getUrlForPane(pane_name) {
            return `/plugins/docman/?group_id=${this.project_id}&id=${
                this.item.id
            }&action=details&section=${pane_name}`;
        }
    }
};
</script>
