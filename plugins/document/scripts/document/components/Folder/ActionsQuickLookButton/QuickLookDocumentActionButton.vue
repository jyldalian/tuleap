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
    <div class="document-quick-look-folder-action">
        <div class="tlp-dropdown-split-button">
            <update-item-button v-bind:item="item"
                                v-bind:button-classes="'tlp-button-primary tlp-button-outline tlp-button-small tlp-dropdown-split-button-main'"
                                v-bind:icon-classes="'fa fa-mail-forward tlp-button-icon'"
                                v-if="! is_item_a_wiki_with_approval_table"
                                data-test="docman-quicklook-action-button-update"
            />
            <dropdown-button
                v-bind:is-in-quick-look-mode="true"
                v-bind:is-appended="item.user_can_write && ! is_item_a_wiki_with_approval_table"
            >
                <dropdown-menu
                    v-bind:item="item"
                    v-bind:is-in-quick-look-mode="true"
                    v-bind:hide-item-title="true"
                    v-bind:hide-details-entry="isDetailsButtonShown"
                />
            </dropdown-button>
        </div>
    </div>
</template>

<script>
import { TYPE_WIKI } from "../../../constants.js";
import DropdownButton from "../ActionsDropDown/DropdownButton.vue";
import DropdownMenu from "../ActionsDropDown/DropdownMenu.vue";
import UpdateItemButton from "../ActionsButton/UpdateItemButton.vue";

export default {
    components: { UpdateItemButton, DropdownButton, DropdownMenu },
    props: {
        item: Object,
        isDetailsButtonShown: Boolean
    },
    computed: {
        is_item_a_wiki_with_approval_table() {
            return this.item.type === TYPE_WIKI && this.item.approval_table !== null;
        }
    }
};
</script>
