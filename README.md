# processor-add-row-number-column

Takes all tables in `/data/in/tables` and appends a column with the row number starting from 1 (column name optional) and stores the files to `/data/out/tables`. 

 - Does not ignores directory structure (for sliced files).
 - Updates manifest file.

## Prerequisites

All CSV files must

- not have headers
- have a manifest file with `columns`, `delimiter` and `enclosure` properties
 
## Usage
Supports optional parameters:

- `column_name ` -- Name of the column, defaults to `row_number`


### Sample configurations

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
    	"column_name": "myRowNumberColumn"
	}
}

```
 
## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/processor-add-row-number-column
cd processor-add-row-number-column
docker-compose build
docker-compose run dev composer install
```

Run the test suite using this command:

```
docker-compose run tests
```
 
## Integration
 - Build is started after push on [Travis CI](https://travis-ci.org/keboola/processor-add-row-number-column)
 - [Build steps](https://github.com/keboola/processor-add-row-number-column/blob/master/.travis.yml)
   - build image
   - execute tests against new image
   - publish image to ECR if release is tagged
   

## License

MIT licensed, see [LICENSE](./LICENSE) file.
