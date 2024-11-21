$("._tab").click(function() {
    let parentBlock = $(this).parents("._tabs-parent")
    let tabId = $(this).attr("data-tab")
    $(parentBlock).find("._tab").removeClass("_active")
    $(this).addClass("_active")
    $(parentBlock).find(".tab-content").removeClass("_active")
    $(parentBlock).find(`.${tabId}`).addClass("_active")
})
