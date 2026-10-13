/**
 * HBYS Dynamic Table & List Live Filter Engine
 * Automatically filters table rows and list-groups in real-time based on header filter inputs/selects.
 */
document.addEventListener('DOMContentLoaded', function () {
    initDynamicTableFilters();
    initDynamicListGroupSearch();
});

function initDynamicTableFilters() {
    const filterableTables = document.querySelectorAll('table[data-dynamic-filter="true"]');

    filterableTables.forEach(table => {
        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        const filterInputs = table.querySelectorAll('.table-filter-input, .table-filter-select');
        const countBadgeSelector = table.getAttribute('data-count-badge');
        const countBadge = countBadgeSelector ? document.querySelector(countBadgeSelector) : null;
        
        function applyFilters() {
            const rows = Array.from(tbody.querySelectorAll('tr:not(.no-filter-match-row)'));
            let visibleCount = 0;

            rows.forEach(row => {
                let match = true;

                filterInputs.forEach(input => {
                    const colIndex = parseInt(input.getAttribute('data-col-index'), 10);
                    const filterVal = input.value.trim().toLowerCase();

                    if (filterVal !== '' && !isNaN(colIndex)) {
                        const cell = row.children[colIndex];
                        if (cell) {
                            const cellText = cell.innerText.toLowerCase();
                            if (input.tagName === 'SELECT' && input.getAttribute('data-filter-mode') === 'exact') {
                                if (cellText.indexOf(filterVal) === -1) {
                                    match = false;
                                }
                            } else {
                                if (cellText.indexOf(filterVal) === -1) {
                                    match = false;
                                }
                            }
                        }
                    }
                });

                if (match) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update badge counter if exists
            if (countBadge) {
                const isFiltered = Array.from(filterInputs).some(i => i.value.trim() !== '');
                const origLabel = countBadge.getAttribute('data-orig-label') || countBadge.textContent;
                if (!countBadge.hasAttribute('data-orig-label')) {
                    countBadge.setAttribute('data-orig-label', origLabel);
                }
                
                if (isFiltered) {
                    countBadge.textContent = visibleCount + ' Hasta (Filtrelendi)';
                } else {
                    countBadge.textContent = countBadge.getAttribute('data-orig-label');
                }
            }

            // Handle empty search feedback row
            let noMatchRow = tbody.querySelector('.no-filter-match-row');
            if (visibleCount === 0) {
                if (!noMatchRow) {
                    noMatchRow = document.createElement('tr');
                    noMatchRow.className = 'no-filter-match-row';
                    const colCount = table.querySelectorAll('thead tr:first-child th').length || 6;
                    noMatchRow.innerHTML = `
                        <td colspan="${colCount}" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-filter-circle-xmark fs-2 text-secondary opacity-50 mb-2"></i>
                            <div>Girilen filtre kriterlerine uygun hasta kaydı bulunamadı.</div>
                        </td>
                    `;
                    tbody.appendChild(noMatchRow);
                } else {
                    noMatchRow.style.display = '';
                }
            } else if (noMatchRow) {
                noMatchRow.style.display = 'none';
            }
        }

        filterInputs.forEach(input => {
            input.addEventListener('input', applyFilters);
            input.addEventListener('change', applyFilters);
        });
    });
}

function initDynamicListGroupSearch() {
    const listGroupSearchInputs = document.querySelectorAll('[data-dynamic-list-search]');
    listGroupSearchInputs.forEach(input => {
        const targetSelector = input.getAttribute('data-dynamic-list-search');
        const listContainer = document.querySelector(targetSelector);
        if (!listContainer) return;

        input.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            const items = listContainer.querySelectorAll('.patient-item, .list-group-item');

            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                if (text.indexOf(query) !== -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}
