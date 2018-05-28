/**
 * script locaQuery.js
 * XXX
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-04-06
*/

window.onload = function(){
    
    // add event listeners to the buttons 'addRule[0]' and 'removeRule[0]':
    document.getElementById('addRule[0]').
        addEventListener('click', addRule, false);
    document.getElementById('removeRule[0]').
        addEventListener('click', removeRule, false);
    
    // event listeners to the select 'ruleFields':
    document.getElementById('ruleFields[0]').
        addEventListener('change', changeRuleField, false);
    
    // button removeRule[0] is not shown on page load:
    document.getElementById('removeRule[0]').style.visibility = 'hidden';
    
}

function addRule(evt) {
    
    var hr, select, att, option, label, br, txt, input, button;
    
    // rulesAmount is retrieved from the already existing 'ruleFields':
    var rulesAmount =
        document.querySelectorAll("select[name^='ruleFields[']").length + 1;

    // rules is the fieldset element
    // at the beggining of which the binding message is displayed
    // and at the end new rules are added:
    var rules = document.getElementById('rules');
    
    // modify message with binding condition:
    
    var rulesBinding = document.getElementById('rulesBinding');
    
    if (rulesBinding === null) {
        
/*
 * binding message is used to specify which kind of binding
 * will have all rules within the resulting query, i.e. AND or OR.
 * in other words, rulesBinding specifies whether all the rules are satisfied,
 * or only some of them.
 * 
 * i) SELECT ... WHERE rule#1 AND rule#2 AND ...
 * 
 * ii) SELECT ... WHERE rule#1 OR rule#2 OR ...
 * 
 * binding message has only sense when there are two or more rules.
 * here in addRules it must be shown when rulesAmount > 1,
 * and in removeRules it must be unshown when rulesAmount < 2.
 * 
 * binding message is shown at the top of the rules,
 * after 'Find experiences where', with the following HTML:
 * <select id="rulesBinding" name="rulesBinding">
 *  <option value="all">all</option>
 *  <option value="any">any</option>
 * </select>
 * <label for="rulesBinding" name="rulesBinding">of the following are true
 *  </label><br />
 */
        
        if (rulesAmount > 1) {
            
            select = document.createElement('select');
            att = document.createAttribute('id');
            att.value = 'rulesBinding';
            select.setAttributeNode(att);
            att = document.createAttribute('name');
            att.value = 'rulesBinding';
            select.setAttributeNode(att);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'all';
            option.setAttributeNode(att);
            txt = document.createTextNode('all');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'any';
            option.setAttributeNode(att);
            txt = document.createTextNode('any');
            option.appendChild(txt);
            select.appendChild(option);
            
            label = document.createElement('label');
            att = document.createAttribute('for');
            att.value = 'rulesBinding';
            label.setAttributeNode(att);
            att = document.createAttribute('id');
            att.value = 'rulesBindingLabel';
            label.setAttributeNode(att);
            txt = document.createTextNode('of the following are true');
            label.appendChild(txt);
            
            br = document.createElement('br');
            att = document.createAttribute('id');
            att.value = 'rulesBindingBr';
            br.setAttributeNode(att);
            
            rules.insertBefore(select, rules.childNodes[0]);
            rules.insertBefore(label, rules.childNodes[1]);
            rules.insertBefore(br, rules.childNodes[2]);
            
        }
            
    }

    // insert an horizontal rule to separate rules:
    hr = document.createElement('hr');
    att = document.createAttribute('id');
    att.value = 'hrRule' + (rulesAmount - 1);
    hr.setAttributeNode(att);
    rules.appendChild(hr);
    
    // create new rule using 'ruleFields', 'ruleCriteria' and 'ruleStrings':
    
    // select 'ruleFields':
    
/*
 * ruleFields is an array of fields,
 * each one containing the field affected by each rule.
 * the fields are those of the joined tables 'loca', 'countries' and 'kinds',
 * when not specified from table 'loca':
 * - locusID
 * - achtung
 * - name
 * - country.countryName
 * - kinds.kindName
 * - description
 * - rating
 * - address
 * - coordinatesExact
 * - coordinatesGeneric
 * - www
 */
    
    select = document.createElement('select');
    att = document.createAttribute('name');
    att.value = 'ruleFields[' + (rulesAmount - 1) + ']'; // array 0-based
    select.setAttributeNode(att);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'country';
    option.setAttributeNode(att);
    txt = document.createTextNode('Country');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'kind';
    option.setAttributeNode(att);
    txt = document.createTextNode('Kind');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'description';
    option.setAttributeNode(att);
    txt = document.createTextNode('Description');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'rating';
    option.setAttributeNode(att);
    txt = document.createTextNode('Rating');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'address';
    option.setAttributeNode(att);
    txt = document.createTextNode('Address');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'coordinatesExact';
    option.setAttributeNode(att);
    txt = document.createTextNode('Coordinates (exact)');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'coordinatesGeneric';
    option.setAttributeNode(att);
    txt = document.createTextNode('Coordinates (generic)');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'www';
    option.setAttributeNode(att);
    txt = document.createTextNode('www');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'locusID';
    option.setAttributeNode(att);
    txt = document.createTextNode('Place ID');
    option.appendChild(txt);
    select.appendChild(option);
    
    rules.appendChild(select);
    
    // event listener is added to the newly created select:
    select.addEventListener('change', changeRuleField, false);
    
    // select 'ruleCriteria:
    
/*
 * ruleCriteria is an array of fields, each one containing the criterion
 * that constituites each rule.
 * the possible criteria for each rule depend of the field considered.
 * the possibilities are the following.
 * 
 * i) text fields (place -if joined-, ordinal, name, description):
 * contains, does not contain, is, is not, begins width, ends width.
 * 
 * ii) numeric fields (locusID, rating):
 * is, is not, is greater than, is less than, is in the range.
 * 
 * the default criterion correspond to a string field.
 * when the field changes the corresponding criteria are updated.
*/
   
    select = document.createElement('select');
    att = document.createAttribute('name');
    att.value = 'ruleCriteria[' + (rulesAmount - 1) + ']'; // array 0-based
    select.setAttributeNode(att);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'contains';
    option.setAttributeNode(att);
    txt = document.createTextNode('contains');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'doesNotContain';
    option.setAttributeNode(att);
    txt = document.createTextNode('does no contain');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'isString';
    option.setAttributeNode(att);
    txt = document.createTextNode('is');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'isNotString';
    option.setAttributeNode(att);
    txt = document.createTextNode('is not');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'beginsWith';
    option.setAttributeNode(att);
    txt = document.createTextNode('begins with');
    option.appendChild(txt);
    select.appendChild(option);
    
    option = document.createElement('option');
    att = document.createAttribute('value');
    att.value = 'endsWith';
    option.setAttributeNode(att);
    txt = document.createTextNode('ends with');
    option.appendChild(txt);
    select.appendChild(option);
    rules.appendChild(select);
    
    // input 'ruleStrings':
    
/*
 * ruleStrings is a single text field in the mayority of cases.
 * however there are some rules that require two ruleStrings fields:
 * - on numeric fields, when the criteron is 'is in the range'
 * - on date fields, with criterion 'is in the range'
*/
    
    input = document.createElement('input');
    att = document.createAttribute('type');
    att.value = 'text';
    input.setAttributeNode(att);
    att = document.createAttribute('name');
    att.value = 'ruleStrings[' + (rulesAmount - 1) + ']'; // array 0-based
    input.setAttributeNode(att);
    rules.appendChild(input);
    
    // button 'addRule':
    button = document.createElement('button');
    att = document.createAttribute('type');
    att.value = 'button';
    button.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'addRule[' + (rulesAmount - 1) + ']'; // array 0-based
    button.setAttributeNode(att);
    txt = document.createTextNode('+');
    button.appendChild(txt);
    rules.appendChild(button);
    
    // event listener is added to the newly created button:
    button.addEventListener('click', addRule, false);
    
    // button 'removeRule':
    button = document.createElement('button');
    att = document.createAttribute('type');
    att.value = 'button';
    button.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'removeRule[' + (rulesAmount - 1) + ']'; // array 0-based
    button.setAttributeNode(att);
    txt = document.createTextNode('-');
    button.appendChild(txt);
    rules.appendChild(button);
    
    // event listener is added to the newly created button:
    button.addEventListener('click', removeRule, false);
    
    // button removeRule[0] shown when rulesAmount > 1:
    if (rulesAmount > 1)
        document.getElementById('removeRule[0]').style.visibility = 'visible';
    else
        document.getElementById('removeRule[0]').style.visibility = 'hidden';
    
    
}

function changeRuleField(evt) {
    
    // get the current rule ordinal:
    var ruleIndex = parseInt(evt.target.name.match(/\d+/g));
    
    var select = evt.target;
    
    switch (select.options[select.selectedIndex].value) {
        
        case 'achtung':
        case 'country':
        case 'kind':
        case 'name':
        case 'description':
        case 'address':
        case 'coordinatesExact':
        case 'coordinatesGeneric':
        case 'www':
        
            updateRuleCriteria(ruleIndex, 'string');
            break;
        
        case 'locusID':
        case 'rating':
        
            updateRuleCriteria(ruleIndex, 'number');
            break;
        
    }
    
}

function removeRule(evt) {
    
    var select, input, button, hr; // DOM
    
/*
 * ruleIndex is the rule currently being removed. it is 0-based
 */

    // get the current rule index from minus button (id="removeRule[XXX]"):
    var ruleIndex = parseInt(evt.target.id.match(/\d+/g));
    
    select =
        document.querySelectorAll("select[name^='ruleFields[']")[ruleIndex];
    select.parentNode.removeChild(select);
    
    select =
        document.querySelectorAll("select[name^='ruleCriteria[']")[ruleIndex];
    select.parentNode.removeChild(select);
    
    input =
        document.querySelectorAll("input[name^='ruleStrings[']")[ruleIndex];
    input.parentNode.removeChild(input);
    
    button = document.querySelectorAll("button[id^='addRule[']")[ruleIndex];
    button.parentNode.removeChild(button);
    
    button = document.querySelectorAll("button[id^='removeRule[']")[ruleIndex];
    button.parentNode.removeChild(button);
    
    if (ruleIndex !== 0) {
        
        hr = document.getElementById('hrRule' + ruleIndex);
        hr.parentNode.removeChild(hr);
    
    } else {
        
        hr = document.getElementById('hrRule1');
        hr.parentNode.removeChild(hr);
        
    }
   
/*
 * when a rule is removed (e.g. rule #3),
 * the indexes of the remaining rules (0, 1, 3...)
 * are to be rearranged (0, 1, 2...)
 * so that the values sent are in a coherent sequence so that
 * they can be succesfully processed.
 */

    var currentIndex;
    var ruleFields = document.querySelectorAll("select[name^='ruleFields[']");
    var ruleCriteria =
        document.querySelectorAll("select[name^='ruleCriteria[']");
    var ruleStrings = document.querySelectorAll("input[name^='ruleStrings[']");

    for (var i = 0; i < ruleFields.length; i ++) {

        currentIndex = parseInt(ruleFields[i].name.match(/\d+/g));
        
        if (currentIndex !== i) {
            
            ruleFields[i].name = 'ruleFields[' + i + ']';
            ruleCriteria[i].name = 'ruleCriteria[' + i + ']';
            ruleStrings[i].name = 'ruleStrings[' + i + ']';
            
            document.getElementById('addRule[' + currentIndex + ']').id =
                'addRule[' + i + ']';
            document.getElementById('removeRule[' + currentIndex + ']').id =
                'removeRule[' + i + ']';
        
            if (document.getElementById('hrRule' + currentIndex) !== null)
                document.getElementById('hrRule' + currentIndex).id = 'hrRule'
                    + i;
            
            i = 0;
            
        }

    }
    
/*
 * rulesAmount is calculated only AFTER deletion commands.
 */    
    var rulesAmount =
        document.querySelectorAll("select[name^='ruleFields[']").length;
    
    // button removeRule[0] shown when rulesAmount > 1:
    if (rulesAmount > 1)
        document.getElementById('removeRule[0]').style.visibility = 'visible';
    else
        document.getElementById('removeRule[0]').style.visibility = 'hidden';
    
    // binding message is removed when rulesAmount < 2. see addRule():
     
    var rulesBinding = document.getElementById('rulesBinding');
    var rulesBindingLabel = document.getElementById('rulesBindingLabel');
    var rulesBindingBr = document.getElementById('rulesBindingBr');

    if ((rulesBinding !== null) && (rulesAmount < 2)) {
        
        rulesBinding.parentElement.removeChild(rulesBinding);
        rulesBindingLabel.parentElement.removeChild(rulesBindingLabel);
        rulesBindingBr.parentElement.removeChild(rulesBindingBr);
        
    }
    
    
}

function updateRuleCriteria(ruleOrdinal, ruleFieldType) {
    
    var select, option, att, txt, input;
    
    select = document.getElementsByName('ruleCriteria[' + ruleOrdinal + ']')[0];
            
    // delete existing options:
    select.options.length = 0;
    
    switch (ruleFieldType) {
        
        case 'string':
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'contains';
            option.setAttributeNode(att);
            txt = document.createTextNode('contains');
            option.appendChild(txt);
            select.appendChild(option);

            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'doesNotContain';
            option.setAttributeNode(att);
            txt = document.createTextNode('does no contain');
            option.appendChild(txt);
            select.appendChild(option);

            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isString';
            option.setAttributeNode(att);
            txt = document.createTextNode('is');
            option.appendChild(txt);
            select.appendChild(option);

            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isNotString';
            option.setAttributeNode(att);
            txt = document.createTextNode('is not');
            option.appendChild(txt);
            select.appendChild(option);

            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'beginsWith';
            option.setAttributeNode(att);
            txt = document.createTextNode('begins with');
            option.appendChild(txt);
            select.appendChild(option);

            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'endsWith';
            option.setAttributeNode(att);
            txt = document.createTextNode('ends with');
            option.appendChild(txt);
            select.appendChild(option);
            
            input = document.getElementsByName('ruleStrings[' + ruleOrdinal +
                ']')[0];
            input.style.visibility = 'visible';
    
            break;
        
        case 'number':
            
            // numeric fields (praxisID, rating, TQ, TL):
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isNumber';
            option.setAttributeNode(att);
            txt = document.createTextNode('is');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isNotNumber';
            option.setAttributeNode(att);
            txt = document.createTextNode('is not');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isGreaterThan';
            option.setAttributeNode(att);
            txt = document.createTextNode('is greater than');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isLessThan';
            option.setAttributeNode(att);
            txt = document.createTextNode('is less than');
            option.appendChild(txt);
            select.appendChild(option);
            
            // is in the range (two fields needed!).
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isInTheRange';
            option.setAttributeNode(att);
            txt = document.createTextNode('is in the range');
            option.appendChild(txt);
            select.appendChild(option);
            
            input = document.getElementsByName('ruleStrings[' + ruleOrdinal +
                ']')[0];
            input.style.visibility = 'visible';
            
            break;
        
        case 'date':
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isDate';
            option.setAttributeNode(att);
            txt = document.createTextNode('is');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isNotDate';
            option.setAttributeNode(att);
            txt = document.createTextNode('is not');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isAfter';
            option.setAttributeNode(att);
            txt = document.createTextNode('is after');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isBefore';
            option.setAttributeNode(att);
            txt = document.createTextNode('is before');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'inTheLast';
            option.setAttributeNode(att);
            txt = document.createTextNode('is the last');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'notInTheLast';
            option.setAttributeNode(att);
            txt = document.createTextNode('not in the last');
            option.appendChild(txt);
            select.appendChild(option);
            
            // is in the range: 2 ruleStrings needed
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isInTheRange';
            option.setAttributeNode(att);
            txt = document.createTextNode('is in the range');
            option.appendChild(txt);
            select.appendChild(option);
            
            input = document.getElementsByName('ruleStrings[' + ruleOrdinal +
                ']')[0];
            input.style.visibility = 'visible';
            
            break;
        
        case 'boolean':
            
            // add new options 'is true' and 'is false'
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isTrue';
            option.setAttributeNode(att);
            txt = document.createTextNode('is true');
            option.appendChild(txt);
            select.appendChild(option);
            
            option = document.createElement('option');
            att = document.createAttribute('value');
            att.value = 'isFalse';
            option.setAttributeNode(att);
            txt = document.createTextNode('is false');
            option.appendChild(txt);
            select.appendChild(option);
        
            input = document.getElementsByName('ruleStrings[' + ruleOrdinal +
                ']')[0];
            input.style.visibility = 'hidden';
            
            break;
            
    }
    
}