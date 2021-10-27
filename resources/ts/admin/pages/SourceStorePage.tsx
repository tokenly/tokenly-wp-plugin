import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceRepository, SourceData, SourceStoreData } from '../../repositories/SourceRepository';
import { SourceStoreForm } from '../components/SourceStoreForm';

declare const wp: any;
declare const window: any;

const { __ } = wp.i18n;

const {
	Button,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

interface SourceIndexPageData {
	//
}

interface SourceIndexPageProps {
	pageData: SourceIndexPageData;
	saving: boolean;
}

interface SourceIndexPageState {
	storingSource: boolean;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	@resolve
	sourceRepository: SourceRepository;
	
	state: SourceIndexPageState = {
		storingSource: false,
	}
	constructor( props: SourceIndexPageProps ) {
		super( props );
		this.onSourceSubmit = this.onSourceSubmit.bind( this );
	}
	
	onSourceSubmit( promise: SourceStoreData ) {
		this.sourceRepository.store( promise ).then( ( result: any ) => {
			window.location = '/wp-admin/admin.php?page=tokenpass-source-index';
		});
	}
	
	render() {
		return (
			<Page title={'Register source address'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<div>
								<div style={ { marginBottom: '12px' } }>
									<a href='/wp-admin/admin.php?page=tokenpass-source-index'>Manage source addresses</a>
								</div>
								<div>
									<SourceStoreForm
										onSubmit={ this.onSourceSubmit }
										saving={ this.state.storingSource }
										style={ { marginBottom: '12px' } }
									/>
								</div>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
