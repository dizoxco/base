export const validator = (model, rules, field = null) => {
    let errors;
    let fields;

    if (model === undefined || rules === undefined) {
        return;
    }

    if (field === null) {
        model.validation = {};
        fields = Object.keys(rules);
        fields.forEach((field) => {
            errors = checkValueAgainstRules(model.attributes[field], rules[field]);
            if (errors) {
                model.validation[field] = errors;
            } else {
                delete model.validation[field];
            }
        });
    } else {
        if (model.validation == undefined) {
            model.validation = {};
        }
        errors = checkValueAgainstRules(model.attributes[field], rules[field]);
        if (errors) {
            model.validation[field] = errors;
        } else {
            delete model.validation[field];
        }
    }

    return model.validation;
};

function checkValueAgainstRules(value, rules) {
    let error = null;
    value = turnEmptyToNull(value);

    for (let rule of rules) {
        switch (rule) {
            case 'required':
                if (!value) {
                    error = 'الزامی است';
                }
                break;
            case 'string':
                if ((typeof value) != "string") {
                    error = 'باید کاراکتر باشد';
                }
                break;
            case 'numeric':
                if (isNaN(parseFloat(value)) && !isFinite(value)) {
                    error = 'باید عدد باشد';
                }
                break;
            default:
                break;
        }

        if (error != null) {
            break;
        }
    }

    return error;
}

function turnEmptyToNull(value) {
    if (value == undefined || value === '' || !value) {
        return value = null;
    }
    return value;
}

