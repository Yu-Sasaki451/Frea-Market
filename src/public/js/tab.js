window.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('[role="tab"]');

    tabs.forEach(tab => {
        tab.addEventListener("click", changeTabs);
    });
});

function changeTabs(e) {
    const target = e.currentTarget;
    const parent = target.parentNode;
    const grandparent = parent.parentNode;
    const isMylist = target.id === "tab-mylist";
    const tabValue = isMylist ? "mylist" : "recommend";

    parent
        .querySelectorAll('[aria-selected="true"]')
        .forEach(t => {
            t.setAttribute("aria-selected", "false");
            t.setAttribute("tabindex", "-1");
        });

    target.setAttribute("aria-selected", "true");
    target.setAttribute("tabindex", "0");

    grandparent
        .querySelectorAll('[role="tabpanel"]')
        .forEach(p => p.setAttribute("hidden", true));

    grandparent.parentNode
        .querySelector(`#${target.getAttribute("aria-controls")}`)
        .removeAttribute("hidden");

    const url = new URL(window.location.href);
    url.searchParams.set("tab", tabValue);
    window.history.replaceState({}, "", url.toString());
}
