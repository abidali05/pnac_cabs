document.addEventListener("DOMContentLoaded", function () {
    console.log("Medical Laboratory JS loaded");

    // --- Add row (event delegation) ---
    document.addEventListener("click", function (event) {
        const addButton = event.target.closest(".js-add-row");
        if (!addButton) return;

        const targetId = addButton.dataset.target;
        console.log("Add button clicked, target:", targetId);

        const tbody = document.getElementById(targetId);
        if (!tbody) {
            console.error("Tbody not found:", targetId);
            return;
        }

        const lastRow = tbody.querySelector("tr");
        if (!lastRow) {
            console.error("No row found in tbody");
            return;
        }

        const clone = lastRow.cloneNode(true);
        const index = tbody.querySelectorAll("tr").length;

        // Update input names and clear values
        clone
            .querySelectorAll("input, textarea, select")
            .forEach(function (field) {
                const name = field.getAttribute("name");
                if (name) {
                    field.setAttribute(
                        "name",
                        name.replace(/\[\d+\]/, "[" + index + "]"),
                    );
                }
                // Reset values
                if (field.tagName === "SELECT" && field.multiple) {
                    Array.from(field.options).forEach(function (opt) {
                        opt.selected = false;
                    });
                } else if (
                    field.type === "checkbox" ||
                    field.type === "radio"
                ) {
                    field.checked = false;
                } else {
                    field.value = "";
                }
            });

        tbody.appendChild(clone);
        console.log("Row added, new index:", index);
    });

    // --- Remove row (event delegation) ---
    document.addEventListener("click", function (event) {
        const removeButton = event.target.closest(".js-remove-row");
        if (!removeButton) return;

        const row = removeButton.closest("tr");
        if (!row) return;

        const tbody = row.closest("tbody");
        if (!tbody) return;

        // Prevent removing the last row
        if (tbody.querySelectorAll("tr").length <= 1) {
            // Clear fields instead of removing
            row.querySelectorAll("input, textarea, select").forEach(
                function (field) {
                    if (field.tagName === "SELECT" && field.multiple) {
                        Array.from(field.options).forEach(function (opt) {
                            opt.selected = false;
                        });
                    } else if (
                        field.type === "checkbox" ||
                        field.type === "radio"
                    ) {
                        field.checked = false;
                    } else {
                        field.value = "";
                    }
                },
            );
            return;
        }

        row.remove();
        console.log("Row removed");
    });

    // --- ISO toggle ---
    function toggleIso() {
        const value = document.querySelector(".mlab-iso-toggle:checked")?.value;
        document
            .querySelectorAll(".mlab-non-compliance-wrap")
            .forEach(function (el) {
                el.classList.toggle("d-none", value !== "no");
            });
    }

    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("mlab-iso-toggle")) toggleIso();
    });

    // --- AJAX form submission ---
    document.querySelectorAll(".mlab-js-card-form").forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            const submitter = event.submitter;
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
                    const url = new URL(window.location.href);
                    url.searchParams.delete("edit_section");
                    url.searchParams.set(
                        "open_section",
                        data.open_section ||
                            form.closest("[data-section]")?.dataset.section ||
                            "step1",
                    );
                    window.location.replace(url.toString()); // use replace to avoid caching
                    //     const url = new URL(window.location.href);
                    //     url.searchParams.delete("edit_section");
                    //     url.searchParams.set(
                    //         "open_section",
                    //         data.open_section ||
                    //             form.closest("[data-section]")?.dataset.section ||
                    //             "step1",
                    //     );
                    //     window.location.replace(url.toString());
                })
                .catch(function () {
                    alert("Unable to save this section. Please try again.");
                });
        });
    });

    toggleIso();
});
