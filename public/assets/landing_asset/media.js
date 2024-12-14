function ucFirst(str) {
    if (!str) return str;
    return str[0].toUpperCase() + str.slice(1);
}

// let mediaScanUrl = Vvveb.mediaScanUrl;
let mediaScanUrl = $("#media_scan_url").val();

class MediaModal {
    constructor(modal = true) {
        this.isInit = false;
        this.isModal = modal;

        this.modalHtml = `
            <div class="modal fade modal-full" id="MediaModal" tabindex="-1" role="dialog" aria-labelledby="MediaModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="MediaModalLabel">Media</h5>
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"><i class="la la-times la-lg"></i></span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="filemanager">
                        <div class="top-right d-flex justify-content-between">
                            <div class="align-left">
                                <div class="breadcrumbs"></div>
                            </div>
                            <div class="align-right">
                                <div class="search">
                                    <input type="search" id="media-search-input" placeholder="Find a file.." />
                                </div>
                                <button class="btn btn-outline-secondary btn-sm btn-icon me-5 float-end" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target=".upload-collapse" 
                                    aria-expanded="false">
                                    <i class="la la-cloud-upload-alt la-lg"></i>
                                    Upload new file
                                </button>
                            </div>
                        </div>
                        <div class="top-panel">
                            <div class="upload-collapse collapse">
                                <button id="upload-close" type="button" class="btn btn-sm btn-light" aria-label="Close" data-bs-toggle="collapse" data-bs-target=".upload-collapse" aria-expanded="true">
                                   <span aria-hidden="true"><i class="la la-times la-lg"></i></span>
                                </button>
                               <h3>Drop or choose files to upload</h3>
                               <input type="file" multiple class="">
                               <div class="status"></div>
                            </div>
                        </div>
                        <div class="display-panel">
                            <ul class="data" id="media-files"></ul>
                            <div class="nothingfound">
                                <div class="nofiles"></div>
                                <span>No files here.</span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <div class="align-left"></div>
                    <div class="align-right">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save-btn">Add selected</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>`;

        this.response = [];
        this.currentPath = "";
        this.breadcrumbsUrls = [];
        this.filemanager = null;
        this.breadcrumbs = null;
        this.fileList = null;
        this.mediaPath = "/public/media/";
        this.type = "single";
    }

    addModalHtml() {
        if (this.isModal) $("body").append(this.modalHtml);
        $("#MediaModal .save-btn").on("click", () => this.save());
    }

    showUploadLoading() {
        $("#MediaModal .upload-collapse .status").html(`
            <div class="spinner-border" style="width: 5rem; height: 5rem;margin: 5rem auto; display:block" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>`);
    }

    hideUploadLoading() {
        $("#MediaModal .upload-collapse .status").html("");
    }

    save() {
        let file = $("#MediaModal .files input:checked").eq(0).val();
        if (this.targetInput) {
            $(this.targetInput).val(file).trigger("change");
        }

        if (file.indexOf("//") == -1) {
            file = this.mediaPath + file;
        }

        if (this.targetThumb) {
            $(this.targetThumb).attr("src", file);
        }

        if (this.callback) {
            this.callback(file);
        }

        if (this.isModal) $("#MediaModal").modal("hide");
    }

    init() {
        if (!this.isInit) {
            if (this.isModal) this.addModalHtml();
            this.initGallery();
            this.isInit = true;

            $(".filemanager input[type=file]").on("change", (e) =>
                this.onUpload(e)
            );
            $(".filemanager").on("click", ".btn-delete", (e) =>
                this.deleteFile(e)
            );
            $(".filemanager").on("click", ".btn-rename", (e) =>
                this.renameFile(e)
            );

            $(window).trigger("mediaModal:init", {
                type: this.type,
                targetInput: this.targetInput,
                targetThumb: this.targetThumb,
                callback: this.callback,
            });
        }
    }

    open(element, callback) {
        if (element instanceof Element) {
            this.targetInput = element.dataset.targetInput;
            this.targetThumb = element.dataset.targetThumb;
            if (element.dataset.type) {
                this.type = element.dataset.type;
            }
        } else if (element) {
            this.targetInput = element.targetInput;
            this.targetThumb = element.targetThumb;
            if (element.type) {
                this.type = element.type;
            }
        }

        this.callback = callback;
        this.init();

        if (this.isModal) $("#MediaModal").modal("show");
    }

    initGallery() {
        this.filemanager = $(".filemanager");
        this.breadcrumbs = $(".breadcrumbs");
        this.fileList = this.filemanager.find(".data");
        let _this = this;

        console.log("Initializing Gallery..."); // Debug log

        $.get(mediaScanUrl, function (data) {
            console.log("Media data fetched: ", data); // Debug log
            _this.response = [data];
            _this.currentPath = "";
            _this.breadcrumbsUrls = [];
            $(window).trigger("hashchange");
        });

        $(window).on("hashchange", function () {
            _this.goto(window.location.hash);
        });

        this.filemanager.find(".search").click(function () {
            let search = $(this);
            search.find("span").hide();
            search.find("input[type=search]").show().focus();
        });

        this.filemanager
            .find("input[type=search]")
            .on("input", function () {
                let value = this.value.trim();
                if (value.length) {
                    _this.filemanager.addClass("searching");
                    window.location.hash = "search=" + value.trim();
                } else {
                    _this.filemanager.removeClass("searching");
                    window.location.hash = encodeURIComponent(
                        _this.currentPath
                    );
                }
            })
            .on("keyup", function (e) {
                if (e.keyCode == 27) {
                    $(this).trigger("focusout");
                }
            })
            .focusout(function () {
                let search = $(this);
                if (!search.val().trim().length) {
                    window.location.hash = encodeURIComponent(
                        _this.currentPath
                    );
                    search.hide();
                    search.parent().find("span").show();
                }
            });

        this.fileList.on("click", "li.folders", function (e) {
            e.preventDefault();
            let nextDir = $(this).find("a.folders").attr("href");

            if (_this.filemanager.hasClass("searching")) {
                _this.breadcrumbsUrls = _this.generateBreadcrumbs(nextDir);
                _this.filemanager.removeClass("searching");
                _this.filemanager.find("input[type=search]").val("").hide();
                _this.filemanager.find("span").show();
            } else {
                _this.breadcrumbsUrls.push(nextDir);
            }

            window.location.hash = encodeURIComponent(nextDir);
            _this.currentPath = nextDir;
        });

        this.breadcrumbs.on("click", "a", function (e) {
            e.preventDefault();
            let index = _this.breadcrumbs.find("a").index($(this));
            let nextDir = _this.breadcrumbsUrls[index];
            _this.breadcrumbsUrls.length = Number(index);
            window.location.hash = encodeURIComponent(nextDir);
        });
    }

    goto(hash) {
        hash = decodeURIComponent(hash).slice(1).split("=");
        let _this = this;

        if (hash.length) {
            let rendered = "";

            if (hash[0] === "search") {
                this.filemanager.addClass("searching");
                rendered = _this.searchData(
                    _this.response,
                    hash[1].toLowerCase()
                );
                this.render(rendered.length ? rendered : []);
            } else if (hash[0].trim().length) {
                rendered = this.searchByPath(hash[0]);

                if (rendered.length) {
                    this.render(rendered);
                } else {
                    this.currentPath = hash[0];
                    this.render(rendered);
                }
            } else {
                this.currentPath = hash[0];
                this.render(this.searchByPath(this.currentPath));
            }
        }
    }

    render(data) {
        let scannedFolders = [];
        let scannedFiles = [];

        if (Array.isArray(data)) {
            data.forEach(function (d) {
                if (d.type === "folder") {
                    scannedFolders.push(d);
                } else if (d.type === "file") {
                    scannedFiles.push(d);
                }
            });
        }

        this.fileList.empty().hide();
        this.generateBreadcrumbs(this.currentPath);
        this.generateItems(scannedFolders, scannedFiles);
        this.fileList.fadeIn();

        let name = this.currentPath.split("/").pop();
        if (name) {
            $("#MediaModalLabel").html(ucFirst(name));
        } else {
            $("#MediaModalLabel").html("Media");
        }
    }

    generateItems(folders, files) {
        let _this = this;

        folders.forEach(function (f) {
            let folder = $(`
                <li class="folders">
                    <a href="${f.path}" title="${f.path}" class="folders">
                        <div class="icon folder">
                            <span>${f.name}</span>
                        </div>
                    </a>
                </li>`);

            folder.appendTo(_this.fileList);
        });

        files.forEach(function (f) {
            let file = $(`
                <li class="files">
                    <a href="${f.path}" title="${f.path}" class="files">
                        <div class="icon file">
                            <span>${f.name}</span>
                        </div>
                    </a>
                </li>`);

            file.appendTo(_this.fileList);
        });

        let totalCount = folders.length + files.length;
        $(".nothingfound").toggle(totalCount == 0);
    }

    generateBreadcrumbs(nextDir) {
        let path = nextDir.split("/");
        let breadcrumbs = [];
        let next = "/";

        for (let i = 0; i < path.length; i++) {
            next += path[i] + "/";
            breadcrumbs.push(next);
        }

        let breadcrumbsHtml = "<li><a href='/'>Home</a></li>";
        for (let i = 0; i < breadcrumbs.length; i++) {
            let name = ucFirst(breadcrumbs[i].split("/").filter(Boolean).pop());
            breadcrumbsHtml += `<li><a href="${breadcrumbs[i]}">${name}</a></li>`;
        }

        $(".breadcrumbs").html(breadcrumbsHtml);
        return breadcrumbs;
    }

    searchData(data, searchTerms) {
        let folders = [];
        let files = [];

        data.forEach(function (d) {
            if (d.type === "folder") {
                this.searchData(d.items, searchTerms).forEach(function (f) {
                    folders.push(f);
                });
            } else if (d.type === "file") {
                if (d.name.toLowerCase().indexOf(searchTerms) !== -1) {
                    files.push(d);
                }
            }
        });

        return { folders: folders, files: files };
    }

    searchByPath(path) {
        let parts = path.split("/").filter(Boolean);
        let part = parts.shift();
        let data = this.response;
        let flag = false;

        while (part) {
            for (let i = 0; i < data.length; i++) {
                if (data[i].name === part) {
                    data = data[i].items;
                    flag = true;
                    break;
                }
            }

            part = parts.shift();
        }

        return flag ? data : [];
    }

    onUpload(e) {
        e.preventDefault();
        let _this = this;
        let files = e.target.files;

        if (files.length) {
            this.showUploadLoading();

            let formData = new FormData();
            formData.append("_token", $("#csrf_token").val());

            for (let i = 0; i < files.length; i++) {
                formData.append("file[]", files[i]);
            }

            var url = $("#media_upload_url").val();

            $.ajax({
                url: url, // Adjust the URL to match your Laravel route
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    _this.hideUploadLoading();
                    _this.initGallery();
                },
                error: function (xhr, status, error) {
                    _this.hideUploadLoading();
                    console.error("Upload error:", status, error);
                },
            });
        }
    }

    deleteFile(e) {
        e.preventDefault();
        let file = $(e.target).closest("li").find("a").attr("href");

        if (confirm("Are you sure you want to delete this file?")) {
            $.ajax({
                url: "/path/to/delete",
                type: "POST",
                data: { file: file },
                success: function (response) {
                    this.initGallery();
                },
                error: function (xhr, status, error) {
                    console.error("Delete error:", status, error);
                },
            });
        }
    }

    renameFile(e) {
        e.preventDefault();
        let file = $(e.target).closest("li").find("a").attr("href");
        let newName = prompt(
            "Enter new name for the file:",
            file.split("/").pop()
        );

        if (newName) {
            $.ajax({
                url: "/path/to/rename",
                type: "POST",
                data: { file: file, newName: newName },
                success: function (response) {
                    this.initGallery();
                },
                error: function (xhr, status, error) {
                    console.error("Rename error:", status, error);
                },
            });
        }
    }
}

Vvveb.MediaModal = new MediaModal();
