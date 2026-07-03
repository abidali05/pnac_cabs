if (window.__cbRepeatableTableInit) {
    // Already initialized — dobara mat chalao
} else {
    window.__cbRepeatableTableInit = true;

    document.addEventListener("DOMContentLoaded", function () {
        // ── Helpers ───────────────────────────────────────────────────────────────

        function recalcCollapseAncestors(el) {
            var node = el.parentElement;
            while (node) {
                if (
                    node.classList.contains("pnac-collapse-body") &&
                    !node.classList.contains("collapse")
                ) {
                    node.style.maxHeight = node.scrollHeight + "px";
                }
                node = node.parentElement;
            }
        }

        function clearFields(fields) {
            fields.forEach(function (f) {
                if (f.tagName === "SELECT" && f.multiple) {
                    Array.from(f.options).forEach(function (o) {
                        o.selected = false;
                    });
                } else if (f.type === "checkbox" || f.type === "radio") {
                    f.checked = false;
                } else {
                    f.value = "";
                }
            });
        }

        // ── Add row — event delegation (works on collapsed/hidden sections) ────────
        document.addEventListener("click", function (event) {
            if (!document.querySelector(".cb-application-form")) return;

            var btn = event.target.closest(".js-add-row");
            if (!btn) return;

            var tbody = document.getElementById(btn.dataset.target);
            if (!tbody) return;

            var lastRow = tbody.querySelector("tr:last-child");
            if (!lastRow) return;

            var clone = lastRow.cloneNode(true);
            var newIndex = tbody.querySelectorAll("tr").length;

            clone
                .querySelectorAll("input, textarea, select")
                .forEach(function (f) {
                    var name = f.getAttribute("name");
                    if (name) {
                        f.setAttribute(
                            "name",
                            name.replace(/\[(\d+)\]/, "[" + newIndex + "]"),
                        );
                    }
                });

            clearFields(clone.querySelectorAll("input, textarea, select"));

            tbody.appendChild(clone);
            recalcCollapseAncestors(tbody);
        });

        // ── Remove row — event delegation ─────────────────────────────────────────
        document.addEventListener("click", function (event) {
            if (!document.querySelector(".cb-application-form")) return;

            var btn = event.target.closest(".js-remove-row");
            if (!btn) return;

            var row = btn.closest("tr");
            var tbody = row && row.closest("tbody");
            if (!tbody) return;

            if (tbody.querySelectorAll("tr").length <= 1) {
                clearFields(row.querySelectorAll("input, textarea, select"));
                return;
            }

            row.remove();

            tbody.querySelectorAll("tr").forEach(function (tr, idx) {
                tr.querySelectorAll("input, textarea, select").forEach(
                    function (f) {
                        var name = f.getAttribute("name");
                        if (name) {
                            f.setAttribute(
                                "name",
                                name.replace(/\[(\d+)\]/, "[" + idx + "]"),
                            );
                        }
                    },
                );
            });

            recalcCollapseAncestors(tbody);
        });

        // ── Toggle helpers ────────────────────────────────────────────────────────

        function toggleOther() {
            var el = document.querySelector('.cb-other-toggle[value="Other"]');
            var checked = el && el.checked;
            document.querySelectorAll(".cb-other-wrap").forEach(function (w) {
                w.classList.toggle("d-none", !checked);
            });
        }

        function toggleOwnership() {
            var sel = document.querySelector(".cb-ownership-select");
            var show = sel && sel.value === "Other";
            document
                .querySelectorAll(".cb-ownership-other")
                .forEach(function (w) {
                    w.classList.toggle("d-none", !show);
                });
        }

        function toggleActivity() {
            var sel = document.querySelector(".cb-main-activity-select");
            var show = sel && sel.value === "no";
            document
                .querySelectorAll(".cb-main-activity-description")
                .forEach(function (w) {
                    w.classList.toggle("d-none", !show);
                });
        }

        function toggleQuality() {
            var el = document.querySelector(".cb-quality-toggle:checked");
            var isNo = el && el.value === "no";
            document
                .querySelectorAll(".cb-non-compliance-wrap")
                .forEach(function (w) {
                    w.classList.toggle("d-none", !isNo);
                });
        }

        document.addEventListener("change", function (event) {
            if (event.target.classList.contains("cb-other-toggle"))
                toggleOther();
            if (event.target.classList.contains("cb-ownership-select"))
                toggleOwnership();
            if (event.target.classList.contains("cb-main-activity-select"))
                toggleActivity();
            if (event.target.classList.contains("cb-quality-toggle"))
                toggleQuality();
        });

        // ── AJAX form submission ─────────────────────────────────────────────────
        document.querySelectorAll(".cb-js-card-form").forEach(function (form) {
            form.addEventListener("submit", function (event) {
                event.preventDefault();

                var missing = [];
                form.querySelectorAll("[required]").forEach(function (field) {
                    if (field.type === "radio") {
                        var checked = form.querySelector(
                            'input[name="' + field.name + '"]:checked',
                        );
                        if (!checked) {
                            var label = getFieldLabel(field);
                            if (!missing.includes(label)) missing.push(label);
                        }
                        return;
                    }
                    if (field.type === "checkbox") {
                        if (!field.checked) missing.push(getFieldLabel(field));
                        return;
                    }
                    if (!field.value || !field.value.trim()) {
                        missing.push(getFieldLabel(field));
                    }
                });

                function getFieldLabel(field) {
                    var wrapper = field.closest(
                        "td, .col-md-3, .col-md-4, .col-md-5, .col-md-8, .col-md-12, .col-12",
                    );
                    var label = wrapper
                        ? wrapper.querySelector("label, th")
                        : null;
                    if (label) return label.textContent.replace("*", "").trim();
                    return field.name;
                }

                if (missing.length > 0) {
                    if (window.Swal) {
                        Swal.fire({
                            icon: "warning",
                            title: "Required Fields Missing",
                            html:
                                "<ul class='text-start mb-0'>" +
                                missing
                                    .map(function (f) {
                                        return "<li>" + f + "</li>";
                                    })
                                    .join("") +
                                "</ul>",
                            confirmButtonText: "OK",
                        });
                    } else {
                        alert("Please fill: " + missing.join(", "));
                    }
                    return;
                }

                var submitter = event.submitter;
                var isFinalSubmit =
                    submitter && submitter.name === "final_submit";
                var formData = new FormData(form);

                if (submitter && submitter.name) {
                    formData.set(submitter.name, submitter.value || "1");
                }

                fetch(form.action, {
                    method: form.method || "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                })
                    .then(function (response) {
                        return response
                            .json()
                            .catch(function () {
                                return {};
                            })
                            .then(function (data) {
                                return { ok: response.ok, data: data };
                            });
                    })
                    .then(function (result) {
                        var data = result.data;

                        if (!result.ok) {
                            var errors = data.errors || {};
                            var firstKey = Object.keys(errors)[0];
                            var msg = firstKey
                                ? errors[firstKey][0]
                                : data.message ||
                                  "Unable to save this section.";
                            if (window.Swal) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Validation Error",
                                    text: msg,
                                });
                            } else {
                                alert(msg);
                            }
                            return;
                        }

                        if (isFinalSubmit && data.redirect_url) {
                            window.location.href = data.redirect_url;
                            return;
                        }

                        var url = new URL(window.location.href);
                        url.searchParams.delete("edit_section");
                        url.searchParams.set(
                            "open_section",
                            data.open_section ||
                                (form.closest("[data-section]") &&
                                    form.closest("[data-section]").dataset
                                        .section) ||
                                "basic_info",
                        );
                        window.location.href = url.toString();
                    })
                    .catch(function () {
                        if (window.Swal) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Unable to save this section. Please try again.",
                            });
                        } else {
                            alert(
                                "Unable to save this section. Please try again.",
                            );
                        }
                    });
            });
        });

        toggleOther();
        toggleOwnership();
        toggleActivity();
        toggleQuality();
    });
}
