$(document).ready(function () {
    q = window.location.search;
    var a = false;
    if (q.substring(0, 1) == "?" && q.length >= 2) {
        r = decodeURIComponent(q.substring(1)).replace(/,/g, "\n");
        $("#txtInput").val(r);
        if ($.trim(r).length >= 2) {
            SendData(r);
            if ($("#error").length) {
                $("#error").hide().remove()
            }
            a = true
        } else {
            error("Input is not long enough!")
        }
    }
    $(document).one("keydown", function (b) {
        if (!a) {
            $("#txtInput").focus()
        }
    });
    $("#submit, #mini-submit").click(function (b) {
        if (Valid()) {
            SendData($("#txtInput").val().replace(/\"/g, "'").replace(/\\/g, "/"));
            if ($("#error").length) {
                $("#error").hide().remove()
            }
        } else {
            error("Input is not long enough!")
        }
        b.preventDefault()
    });
    $("#outputb").mouseenter(function () {
        this.select()
    }).mouseleave(function () {
        this.selectionStart = this.selectionEnd = $(this).val().length
    })
});

function error(a) {
    if ($("#error").length == 0) {
        $('<div id="error"></div>').insertBefore("#mode").text(a).fadeIn();
        $("#profile-wrap, #output").hide();
        $("#wrapper").css("width", "468px")
    }
}

function Valid(a) {
    if ($.trim($("#txtInput").val()).length >= 2) {
        return true
    }
}
var dataRequest, dReqCounter = 0;

function SendData(e) {
    var b = "";
    var c = 0;
    var a = false;
    var f = false;
    if (dataRequest) {
        dataRequest.abort()
    }
    var d = ++dReqCounter;
    dataRequest = $.ajax({
        type: "POST",
        url: "Converter.asmx/SimpleData",
        beforeSend: function () {
            if (!$("#data-loading").length) {
                $("<div />").attr("id", "data-loading").hide().prependTo("#input-box").fadeIn()
            }
        },
        data: '{ "UserInput" : "' + e + '"}',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (h) {
            if (d != dReqCounter) {
                return
            }
            $("#data-loading").hide(function () {
                $(this).remove()
            });
            var g = h.d.split(",");
            if (g[0] != "null") {
                $("#outputb").val(g[1]).show("fast", "swing").select();
                LoadProfile(g[0])
            } else {
                error(g[1])
            }
        },
        error: function () {
            error("Error :(");
            if ($("#data-loading")) {
                $("#data-loading").hide(function () {
                    $(this).remove()
                })
            }
        }
    })
}
var profileRequest, pReqCounter = 0;
var loadingProfile = false;

function LoadProfile(b) {
    if (b == "null") {
        return
    }
    if (profileRequest) {
        profileRequest.abort()
    }
    var a = ++pReqCounter;
    profileRequest = $.ajax({
        type: "POST",
        url: "ProfileLoad.asmx/LoadProfile",
        beforeSend: function () {
            $("#profile-wrap").fadeIn("fast");
            if (loadingProfile == false) {
                loadingProfile = true;
                $("<div></div>").attr("id", "profile-loading").hide().prependTo("#profile-wrap").fadeIn("slow")
            }
        },
        data: '{ "Profile" : "' + b + '"}',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        success: function (f) {
            if (a != pReqCounter) {
                return
            }
            loadingProfile = false;
            $("#profile-loading").hide(function () {
                $(this).remove()
            });
            $("#profile, #links").fadeIn("slow");
            var c = "";
            var h = f.d.onlineState;
            var e = f.d.steamID;
            var g = "#898989";
            var d = "../img/default.jpg";
            if (e != "") {
                $("#name > a").text(e);
                d = f.d.avatarMedium;
                c = f.d.stateMessage
            } else {
                $("#name > a").text("This user has not yet set up their Steam Community profile.");
                d = "../img/default.jpg";
                c = ""
            }
            $("#avatar").attr("src", d);
            $("#status").html(c);
            if (h == "online") {
                g = "#8ECAFE";
                $("#game-logo").hide()
            } else {
                if (h == "offline") {
                    g = "#898989";
                    $("#game-logo").hide()
                } else {
                    if (h == "in-game") {
                        g = "#8BC53F";
                        $("#game-logo").attr("src", f.d.gameLogo).show()
                    } else {
                        g = "#898989";
                        $("#game-logo").hide()
                    }
                }
            }
            $("#name > a, #status").css("color", g);
            $(".profile-link").attr("href", "http://steamcommunity.com/profiles/" + b);
            $("#avatar").css("border-color", g);
            $("#sig-link").attr("href", "http://steamprofile.com/index.php?steamid=" + b);
            $("#tf2items-link").attr("href", "http://tf2items.com/profiles/" + b);
            $("#tf2stats-link").attr("href", "http://tf2stats.net/player/" + b);
            $("#add-link").attr("href", "steam://friends/add/" + b)
        },
        error: function () {
            error("Profile loading error! :(")
        }
    })
};