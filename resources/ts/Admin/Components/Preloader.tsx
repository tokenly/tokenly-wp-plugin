import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Spinner,
} from '@wordpress/components';

interface PreloaderProps {
	loading: boolean;
	href?: string;
}

interface PreloaderState {
	//
}

export default class Preloader extends Component<PreloaderProps, PreloaderState> {
	constructor( props: PreloaderProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify="flex-start" align="center" style={ { minHeight: '30px' } }>
				<strong>
					{ this.props.children }
				</strong>
			{ this.props.loading &&
				<Spinner />
			}
			</Flex>
		);
	}
}
 

