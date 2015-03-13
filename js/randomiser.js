
function shuffle(o) {
    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
};



function getRandomList(list, group, limit) {
    var data = [];
    while (data.length < limit) {
        var i = Math.floor(Math.random()*list.length);
        var groupname = list[i];
        
        if (group == groupname) {
            continue;
        }
        
        data.push(groupname);
        

        for (i=0; i<data.length-1; i++) {
            var temp = data[i];
            if (groupname == temp) {
                data.pop();
            }
        }
    }
    return data;
}

function getAssignList(list, limit) {
    var data = {};
    for (i = 0; i < list.length ; i++) {
        data[""+list[i]] = getRandomList(list, list[i], limit);
        
    }
    
    return data;
}

