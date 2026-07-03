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

    // ── Add row (event delegation) ────────────────────────────────────────────
    document.addEventListener("click", function (e) {
        if (!document.querySelector(".ib-application-form")) return;

        var btn = e.target.closest(".js-add-row");
        if (!btn) return;

        var tbody = document.getElementById(btn.dataset.target);
        if (!tbody) return;

        var lastRow = tbody.querySelector("tr:last-child");
        if (!lastRow) return;

        var clone    = lastRow.cloneNode(true);
        var newIndex = tbody.querySelectorAll("tr").length;

        clone.querySelectorAll("input, textarea, select").forEach(function (f) {
            var name = f.getAttribute("name");
            if (name) {
                f.setAttribute("name", name.replace(/\[(\d+)\]/, "[" + newIndex + "]"));
            }
        });

        clearFields(clone.querySelectorAll("input, textarea, select"));

        tbody.appendChild(clone);
        recalcCollapseAncestors(tbody);
    });

    // ── Remove row (event delegation) ─────────────────────────────────────────
    document.addEventListener("click", function (e) {
        if (!document.querySelector(".ib-application-form")) return;

        var btn   = e.target.closest(".js-remove-row");
        if (!btn) return;

        var row   = btn.closest("tr");
        var tbody = row && row.closest("tbody");
        if (!tbody) return;

        if (tbody.querySelectorAll("tr").length <= 1) {
            clearFields(row.querySelectorAll("input, textarea, select"));
            return;
        }

        row.remove();

        // Re-index remaining rows so array indexes stay sequential
        tbody.querySelectorAll("tr").forEach(function (tr, idx) {
            tr.querySelectorAll("input, textarea, select").forEach(function (f) {
                var name = f.getAttribute("name");
                if (name) {
                    f.setAttribute("name", name.replace(/\[(\d+)\]/, "[" + idx + "]"));
                }
            });
        });

        recalcCollapseAncestors(tbody);
    });

    // ── AJAX form submission ──────────────────────────────────────────────────
    document.querySelectorAll(".ib-js-card-form").forEach(function (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            var submitter      = e.submitter;
            var isFinalSubmit  = submitter && submitter.name === "final_submit";
            var formData       = new FormData(form);

            if (submitter && submitter.name) {
                formData.set(submitter.name, submitter.value || "1");
            }

            fetch(form.action, {
                method:  form.method || "POST",
                body:    formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept:             "application/json",
                },
            })
                .then(function (response) {
                    return response.json().catch(function () { return {}; }).then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    var data = result.data;

                    if (!result.ok) {
                        var errors   = data.errors || {};
                        var firstKey = Object.keys(errors)[0];
                        alert(firstKey ? errors[firstKey][0] : data.message || "Unable to save this section.");
                        return;
                    }

                    // After final submit redirect to the view provided by the server
                    if (isFinalSubmit && data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }

                    var url = new URL(window.location.href);
                    url.searchParams.delete("edit_section");
                    url.searchParams.set(
                        "open_section",
                        data.open_section ||
                            (form.closest("[data-section]") && form.closest("[data-section]").dataset.section) ||
                            "step1"
                    );
                    window.location.replace(url.toString());
                })
                .catch(function () {
                    alert("Unable to save this section. Please try again.");
                });
        });
    });
});
