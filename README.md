# processor-add-row-number-column

[![Build Status](https://travis-ci.org/keboola/processor-add-row-number-column.svg?branch=master)](https://travis-ci.org/keboola/processor-add-row-number-column)

Takes all CSV files in `/data/in/tables` (except `.manifest` files) and appends column with the row number starting from 1 (column name optional, headers ignored) and stores the files to `/data/out/tables`. 

 - Does not ignores directory structure (for sliced files).
 - Ignores manifests `columns` attribute.
 - Can add column header.
 
## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/processor-add-row-number-column
cd processor-add-row-number-column
docker-compose build
```

Run the test suite using this command:

```
./tests/run.sh
```
 
# Integration
 - Build is started after push on [Travis CI](https://travis-ci.org/keboola/processor-add-row-number-column)
 - [Build steps](https://github.com/keboola/processor-add-row-number-column/blob/master/.travis.yml)
   - build image
   - execute tests against new image
   - publish image to ECR if release is tagged
   
# Usage
It supports optional parameters:

- `column_name ` -- Name of the column. The first row of each CSV file is the header.
- `delimiter` -- CSV delimiter, defaults to `,`
- `enclosure` -- CSV enclosure, defaults to `"`
- `escaped_by` -- escape character for the enclosure, defaults to empty

## Sample configurations

Default parameters:

```
{  
    "definition": {
        "component": "keboola.processor-add-row-number-column"
    }
}
```

Add column name header:

```
{
    "definition": {
        "component": "keboola.processor-add-row-number-column"
    },
    "parameters": {
    	"column_name": "filename"
	}
}

```

Use tab as delimiter and single quote as enclosure:

```
{
    "definition": {
        "component": "keboola.processor-add-row-number-column"
    },
    "parameters": {
    	"delimiter": "\t",
    	"enclosure": "'"
	}
}
```
