/*
 * Copyright (c) Enalean, 2018. All Rights Reserved.
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

import { mockFetchError } from "tlp-mocks";
import { loadRootDocumentId, loadFolderContent } from "./actions.js";
import {
    restore as restoreRestQuerier,
    rewire$getProject,
    rewire$getFolderContent
} from "../api/rest-querier.js";

describe("Store actions", () => {
    afterEach(() => {
        restoreRestQuerier();
    });

    let context, getFolderContent, getProject;

    beforeEach(() => {
        const project_id = 101;
        context = {
            commit: jasmine.createSpy("commit"),
            state: {
                project_id
            }
        };

        getFolderContent = jasmine.createSpy("getFolderContent");
        rewire$getFolderContent(getFolderContent);

        getProject = jasmine.createSpy("getProject");
        rewire$getProject(getProject);
    });

    describe("loadRootDocumentId()", () => {
        it("load document root and then load its own content", async () => {
            const project = {
                additional_informations: {
                    docman: {
                        root_item: {
                            item_id: 3,
                            name: "Project Documentation",
                            owner: {
                                id: 101,
                                display_name: "user (login)"
                            },
                            last_update_date: "2018-08-21T17:01:49+02:00"
                        }
                    }
                }
            };

            getProject.and.returnValue(project);

            const folder_content = [
                {
                    item_id: 1,
                    name: "folder",
                    owner: {
                        id: 101
                    },
                    last_update_date: "2018-10-03T11:16:11+02:00"
                },
                {
                    item_id: 2,
                    name: "item",
                    owner: {
                        id: 101
                    },
                    last_update_date: "2018-08-07T16:42:49+02:00"
                }
            ];

            getFolderContent.and.returnValue(folder_content);

            await loadRootDocumentId(context);

            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", true);
            expect(context.commit).toHaveBeenCalledWith("saveDocumentRootId", 3);
            expect(context.commit).toHaveBeenCalledWith("saveFolderContent", folder_content);
            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", false);
        });

        it("When the user does not have access to the project, an error will be raised", async () => {
            mockFetchError(getProject, {
                status: 403,
                error_json: {
                    error: {
                        message: "User can't access project"
                    }
                }
            });

            await loadRootDocumentId(context);

            expect(context.commit).not.toHaveBeenCalledWith("saveDocumentRootId");
            expect(context.commit).toHaveBeenCalledWith("switchFolderPermissionError");
            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", false);
        });

        it("When the project can't be found, an error will be raised", async () => {
            const error_message = "Project does not exist.";
            mockFetchError(getProject, {
                status: 404,
                error_json: {
                    error: {
                        message: error_message
                    }
                }
            });

            await loadRootDocumentId(context);

            expect(context.commit).not.toHaveBeenCalledWith("saveDocumentRootId");
            expect(context.commit).toHaveBeenCalledWith("setFolderLoadingError", error_message);
            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", false);
        });
    });

    describe("loadFolderContent", () => {
        it("loads the folder content and sets loading flag", async () => {
            const folder_content = [
                {
                    item_id: 1,
                    name: "folder",
                    owner: {
                        id: 101
                    },
                    last_update_date: "2018-10-03T11:16:11+02:00"
                },
                {
                    item_id: 2,
                    name: "item",
                    owner: {
                        id: 101
                    },
                    last_update_date: "2018-08-07T16:42:49+02:00"
                }
            ];

            getFolderContent.and.returnValue(folder_content);

            await loadFolderContent(context);

            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", true);
            expect(context.commit).toHaveBeenCalledWith("saveFolderContent", folder_content);
            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", false);
        });

        it("When the folder can't be found, another error screen will be shown", async () => {
            const error_message = "The folder does not exist.";
            mockFetchError(getFolderContent, {
                status: 404,
                error_json: {
                    error: {
                        i18n_error_message: error_message
                    }
                }
            });

            await loadFolderContent(context);

            expect(context.commit).not.toHaveBeenCalledWith("saveFolderContent");
            expect(context.commit).toHaveBeenCalledWith("setFolderLoadingError", error_message);
            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", false);
        });

        it("When the user does not have access to the folder, an error will be raised", async () => {
            mockFetchError(getFolderContent, {
                status: 403,
                error_json: {
                    error: {
                        i18n_error_message: "No you cannot"
                    }
                }
            });

            await loadFolderContent(context);

            expect(context.commit).not.toHaveBeenCalledWith("saveFolderContent");
            expect(context.commit).toHaveBeenCalledWith("switchFolderPermissionError");
            expect(context.commit).toHaveBeenCalledWith("switchLoadingFolder", false);
        });
    });
});