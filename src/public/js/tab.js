window.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('[role="tab"]');
    const tabList = document.querySelector('[role="tablist"]');

    tabs.forEach(tab => {
        tab.addEventListener("click", changeTabs);
    });
})

function changeTabs(e) {
    const target = e.target;
    const parent = target.parentNode;
    const grandparent = parent.parentNode;

    parent
        .querySelectorAll('[aria-selected="true"]')
        .forEach(t => t.setAttribute("aria-selected", false));

    target.setAttribute("aria-selected", true);

    grandparent
        .querySelectorAll('[role="tabpanel"]')
        .forEach(p => p.setAttribute("hidden", true));

    grandparent.parentNode
        .querySelector(`#${target.getAttribute("aria-controls")}`)
        .removeAttribute("hidden");
}