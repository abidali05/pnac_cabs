document.addEventListener("DOMContentLoaded", function () {
    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * After adding or removing a row, recalculate the maxHeight of every
     * non-Bootstrap collapsible ancestor so the content is never clipped.
     */
    function recalcCollapseAncestors(el) {
        let node = el.parentElement;
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
    document.addEventListener("click", function (event) {
        if (!document.querySelector(".mlab-application-form")) return;

        const addButton = event.target.closest(".js-add-row");

        if (!addButton) return;

        const tbody = document.getElementById(addButton.dataset.target);
        if (!tbody) return;

        const lastRow = tbody.querySelector("tr:last-child");
        if (!lastRow) return;

        const clone = lastRow.cloneNode(true);
        const newIndex = tbody.querySelectorAll("tr").length;

        clone.querySelectorAll("input, textarea, select").forEach(function (f) {
            const name = f.getAttribute("name");
            if (name) {
                // Replace the numeric index: name[0][field] → name[N][field]
                f.setAttribute(
                    "name",
                    name.replace(/\[(\d+)\]/, "[" + newIndex + "]"),
                );
            }
        });

        // Clear all values in the new row
        clearFields(clone.querySelectorAll("input, textarea, select"));

        tbody.appendChild(clone);
        recalcCollapseAncestors(tbody);
    });

    // ── Remove row (event delegation) ─────────────────────────────────────────
    document.addEventListener("click", function (event) {
        if (!document.querySelector(".mlab-application-form")) return;

        const removeButton = event.target.closest(".js-remove-row");
        if (!removeButton) return;

        const row = removeButton.closest("tr");
        if (!row) return;

        const tbody = row.closest("tbody");
        if (!tbody) return;

        if (tbody.querySelectorAll("tr").length <= 1) {
            // Keep the last row but clear its values
            clearFields(row.querySelectorAll("input, textarea, select"));
            return;
        }

        row.remove();

        // Re-index remaining rows so name array indexes are sequential
        tbody.querySelectorAll("tr").forEach(function (tr, idx) {
            tr.querySelectorAll("input, textarea, select").forEach(
                function (f) {
                    const name = f.getAttribute("name");
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

    // ── ISO non-compliance toggle ─────────────────────────────────────────────
    function toggleIso() {
        const checked = document.querySelector(".mlab-iso-toggle:checked");
        const isNo = checked && checked.value === "no";
        document
            .querySelectorAll(".mlab-non-compliance-wrap")
            .forEach(function (el) {
                el.classList.toggle("d-none", !isNo);
            });
    }

    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("mlab-iso-toggle")) {
            toggleIso();
            // Re-expand parent collapse after toggling visibility
            recalcCollapseAncestors(event.target);
        }
    });

    // ── AJAX form submission ──────────────────────────────────────────────────
    document.querySelectorAll(".mlab-js-card-form").forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const submitter = event.submitter;
            const isFinalSubmit =
                submitter && submitter.name === "final_submit";
            const formData = new FormData(form);
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
                .then(async function (response) {
                    const data = await response.json().catch(function () {
                        return {};
                    });

                    if (!response.ok) {
                        const errors = data.errors || {};
                        const firstKey = Object.keys(errors)[0];
                        alert(
                            firstKey
                                ? errors[firstKey][0]
                                : data.message ||
                                      "Unable to save this section.",
                        );
                        return;
                    }

                    // On final submit, redirect to submitted view if server provides a redirect_url
                    if (isFinalSubmit && data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }

                    const url = new URL(window.location.href);
                    url.searchParams.delete("edit_section");
                    url.searchParams.set(
                        "open_section",
                        data.open_section ||
                            form.closest("[data-section]")?.dataset.section ||
                            "step1",
                    );
                    window.location.replace(url.toString());
                })
                .catch(function () {
                    alert("Unable to save this section. Please try again.");
                });
        });
    });

    toggleIso();
});
