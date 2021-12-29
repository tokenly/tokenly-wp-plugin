import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components';

interface SourceSelectFieldProps {
	source: any;
	sources: any;
	loading: boolean;
	onChange: any;
}

interface SourceSelectFieldState {
	//
}

export default class SourceSelectField extends Component<SourceSelectFieldProps, SourceSelectFieldState> {

	constructor( props: SourceSelectFieldProps ) {
		super( props );
	}

	getSourceOptions() {
		const options = [
			{
				label: 'Not selected',
				value: '',
			}
		];
		if ( this.props.sources && typeof this.props.sources === 'object' ) {
			Object.keys( this.props.sources ).forEach( ( key ) => {
				options.push( {
					label: this.props.sources[ key ]?.address.label ?? key,
					value: key,
				} );
			});
		}
		return options;
	}

	render() {
		const sourceOptions = this.getSourceOptions();
		return (
			<Flex> 
				<label>
					<div style={{marginBottom: '8px'}} >Source</div>
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
								disabled={this.props.loading || sourceOptions.length === 1}
								value={ this.props.source }
								style={ { width: '100%' } }
								options={ sourceOptions }
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
 

