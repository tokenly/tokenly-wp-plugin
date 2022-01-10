import * as React from 'react';
import { Component } from 'react';

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
}

interface GroupSelectFieldState {
	//
}

export default class GroupSelectField extends Component<GroupSelectFieldProps, GroupSelectFieldState> {

	constructor( props: GroupSelectFieldProps ) {
		super( props );
	}

	getGroupOptions() {
		const options = [
			{
				label: 'Not selected',
				value: '',
			}
		];
		if ( this.props.groups && Array.isArray( this.props.groups ) ) {
			this.props.groups.forEach( ( group: any ) => {
				options.push( {
					label: group.name,
					value: group.uuid,
				} );
			});
		}
		return options;
	}

	render() {
		const groupOptions = this.getGroupOptions();
		return (
			<Flex> 
				<label>
					<div style={ { marginBottom: '8px' } } >Group</div>
					<Flex
						//@ts-ignore
						direction="column"
					>
						<Flex
							style={ { maxWidth: "320px" } }
							justify="flex-start"
							align="center"
							gap={4}
						>
							<SelectControl
								label=""
								disabled={this.props.loading || groupOptions.length === 1}
								value={ this.props.group }
								style={ { width: '100%' } }
								options={ groupOptions }
								required
								onChange={ ( value: any ) => {
									this.props.onChange( value );
								} }
							/>
							{ this.props.loading &&
								<Spinner />
							}
						</Flex>
					</Flex>
				</label>
			</Flex>
		);
	}
}
 

