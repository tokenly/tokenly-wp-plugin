import * as React from 'react';

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components';

interface GroupSelectFieldProps {
	group: any;
	groups: any;
	loading: boolean;
	onChange: any;
	inputProps?: any;
	label?: string;
}

export default function GroupSelectField( props: GroupSelectFieldProps ) {
	function getGroupOptions() {
		const options = [
			{
				label: 'Not selected',
				value: '',
			}
		];
		if ( props.groups && Array.isArray( props.groups ) ) {
			props.groups.forEach( ( group: any ) => {
				options.push( {
					label: group.name,
					value: group.uuid,
				} );
			});
		}
		return options;
	}

	const groupOptions = getGroupOptions();
	return (
		<Flex
			style={ { width: '100%' } }
			justify="flex-start"
			align="center"
			gap={4}
		>
			<div style={ { width: '100%', flex: '1', flexGrow: 1 } }>
				<SelectControl
					label={ props?.label ?? 'Group' }
					disabled={ props.loading || groupOptions.length === 1 }
					value={ props.group }
					style={ { width: '100%' } }
					options={ groupOptions }
					onChange={ ( value: any ) => {
						props.onChange( value );
					} }
					{ ...props?.inputProps }
				/>
				{ props.loading &&
					<Spinner />
				}
			</div>
		</Flex>
	);
}
 

