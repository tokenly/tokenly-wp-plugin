import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Spinner,
} from '@wordpress/components';

interface PreloaderProps {
	label: string;
	loading: boolean;
}

interface PreloaderState {
	//
}

export default class Preloader extends Component<PreloaderProps, PreloaderState> {
	constructor( props: PreloaderProps ) {
		super( props );
	}

	render() {
		if ( this.props.loading ) {
			return (
				<Flex justify="flex-start" align="center">
					<span>{ `Loading ${ this.props.label } ...` }</span>
					<Spinner />
				</Flex>
			);
		} else {
			return ( null );
		}
	}
}
 

