var changeCase = require('change-case');

module.exports = {
    transform : function(schema){
            var schema_fields = schema.split(',');
            var fields = [];

            for (var i = 0; i < schema_fields.length; i++) {

                var parts = schema_fields[i].split(':');

                for (var j = 0; j < parts.length; j++) {
                    parts[j] = parts[j].trim();

                    // first (name) and second (type) element don't need to be suffixed with ()
                    if(j <= 1){
                        continue;
                    }

                    var piece = parts[j];

                    if(!piece.endsWith(')')){
                        parts[j] = piece + '()';
                    }
                }

                var name = parts.shift();
                var type = parts.shift();

                // finalize the transformed array.
                fields.push(['$table', type + "(\'" + name + "\')"].concat(parts));
            }

            return fields;
    },
    fileNameDatePrefix : function(){
        var date = new Date();
        return date.getFullYear() + '_' + ("0" + (date.getMonth() + 1)).slice(-2) + '_'  + ("0" + date.getDate()).slice(-2) + '_' + date.getTime();
    },
    camelToClassName : function(name){
        return changeCase.title(name).replace(/ /g, "");
    }

}